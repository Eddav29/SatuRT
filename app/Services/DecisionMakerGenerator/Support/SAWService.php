<?php

namespace App\Services\DecisionMakerGenerator\Support;

use App\Services\DecisionMakerGenerator\DecisionMakerService;

class SAWService extends DecisionMakerService
{

    private array $stepData = [];

    public function __construct(bool $normalize = true)
    {
        parent::__construct($normalize);
        $this->stepData['decisionMatrix'] = parent::getData();
        $this->calculate();
    }

    public function getStepData(): array
    {
        return $this->stepData;
    }

    public function calculate()
    {
        $this->stepNormalization();
        $this->stepPreferenceValue();
        $this->stepRanking();
    }

    private function stepNormalization()
    {
        try {
            $matrix = $this->stepData['decisionMatrix'];
            $criteriaType = parent::getTipe();

            $columns = [];

            foreach ($matrix as $row) {
                foreach ($row as $colIndex => $value) {
                    $columns[$colIndex][] = (int) $value;
                }
            }

            $min = [];
            $max = [];

            foreach ($columns as $colIndex => $values) {
                $min[$colIndex] = min($values);
                $max[$colIndex] = max($values);
            }

            $X = [];

            for ($i = 0; $i < count($matrix); $i++) {
                $row = [];
                for ($j = 0; $j < count($matrix[1]); $j++) {
                    $value = 0;
                    if ($criteriaType[$j] === 'Benefit') {
                        $value = $this->trimTrailingZeros(number_format(($matrix[$i][$j]) / ($max[$j]), 3, '.', ''));
                    } else {
                        $value = $this->trimTrailingZeros(number_format(($min[$j]) / ($matrix[$i][$j]), 3, '.', ''));
                    }
                    $row[] = $value;
                }
                $X[] = $row;
            }

            $this->stepData['normalized'] = $X;
        } catch (\Throwable $th) {
            abort("Terjadi Kesalahan dalam proses Normalisasi Matriks");
        }
    }

    private function stepPreferenceValue()
    {
        try {
            $matrix = $this->stepData['normalized'];
            $weights = parent::getBobot();
            $alternatif = parent::getAlternatifs();
            $result = [];

            for ($i = 0; $i < count($matrix); $i++) {
                $preferenceValue = 0;
                $baris = [];

                for ($j = 0; $j < count($matrix[1]); $j++) {
                    $value = 0;
                    $value = $matrix[$i][$j] * $weights[$j];
                    $preferenceValue += $value;
                    $baris[] = $this->trimTrailingZeros(number_format($value, 3, '.', ''));
                }
                $baris[] = $this->trimTrailingZeros(number_format($preferenceValue, 3, '.', ''));
                $X[] = $baris;

                $row = [
                    'Alternatif' => $alternatif[$i],
                    'Nilai Preferensi' => $this->trimTrailingZeros(number_format($preferenceValue, 3, '.', '')),
                ];

                $result[] = $row;
            }

            $this->stepData['perhitunganNilaiPreferensi'] = $X;
            $this->stepData['nilaiPreferensi'] = $result;
        } catch (\Throwable $th) {
            abort("Terjadi Kesalahan dalam proses perhitungan Nilai Preferensi");
        }
    }

    private function stepRanking(): void
    {
        try {
            $result = [];
            $preferensi = $this->stepData['nilaiPreferensi'];

            usort($preferensi, function ($a, $b) {
                return $b['Nilai Preferensi'] <=> $a['Nilai Preferensi'];
            });

            foreach ($preferensi as $key => $value) {
                $result[] = [
                    'Alternatif' => $value['Alternatif'],
                    'Nilai Preferensi' => $value['Nilai Preferensi'],
                    'Ranking' => $key + 1,
                ];
            }

            $this->stepData['ranking'] = $result;
        } catch (\Throwable $th) {
            abort("Terjadi Kesalahan dalam proses perankingan");
        }
    }
}
