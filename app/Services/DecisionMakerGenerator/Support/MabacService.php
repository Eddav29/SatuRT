<?php

namespace App\Services\DecisionMakerGenerator\Support;

use App\Services\DecisionMakerGenerator\DecisionMakerService;

class MabacService extends DecisionMakerService
{
    private array $stepData = [];

    public function __construct()
    {
        parent::__construct(false);
        $this->calculate();
    }

    public function getData(): array
    {
        return $this->stepData;
    }

    private function calculate(): void
    {
        $this->decisionMatrix();
        $this->normalizeMatrix();
        $this->weightedMatrix();
        $this->borderForecastAreaMatrix();
        $this->alternativeDistanceMatrix();
        $this->rankingMatrix();
    }

    private function decisionMatrix(): void
    {
        try {
            $this->stepData['decisionMatrix'] = $this->integerData();
        } catch (\Exception $e) {
            throw new \Exception('Terjadi kesalahan saat membuat matriks keputusan');
        }
    }

    private function normalizeMatrix(): void
    {
        try {
            $matrix = $this->transposeMatrix($this->stepData['decisionMatrix']);
            $max = $this->getMax($matrix);
            $min = $this->getMin($matrix);
            $criteriaType = parent::getTipe();
            $X = [];

            for ($i = 0; $i < count($matrix[1]); $i++) {
                $row = [];
                for ($j = 0; $j < count($matrix); $j++) {
                    $value = 0;
                    if ($criteriaType[$j] === 'Benefit') {
                        $value = $this->trimTrailingZeros(number_format(($this->integerData()[$i][$j] - $min[$j]) / ($max[$j] - $min[$j]), 3, '.', ''));
                    } else {
                        $value = $this->trimTrailingZeros(number_format(($this->integerData()[$i][$j] - $max[$j]) / ($min[$j] - $max[$j]), 3, '.', ''));
                    }
                    $row[] = $value;
                }
                $X[] = $row;
            }

            $this->stepData['normalized'] = $X;
        } catch (\Exception $e) {
            throw new \Exception('Terjadi kesalahan saat melakukan normalisasi matriks');
        }
    }

    private function weightedMatrix(): void
    {
        try {
            $weight = parent::getBobot();
            $normalizeMatrix = $this->stepData['normalized'];
            $V = [];

            for ($i = 0; $i < count($normalizeMatrix); $i++) {
                $row = [];
                for ($j = 0; $j < count($normalizeMatrix[$i]); $j++) {
                    $row[] = $this->trimTrailingZeros(number_format((($weight[$j] / 100) * $normalizeMatrix[$i][$j]) + ($weight[$j] / 100), 3, '.', ''));
                }
                $V[] = $row;
            }

            $this->stepData['weightedMatrix'] = $V;
        } catch (\Exception $e) {
            throw new \Exception('Terjadi kesalahan saat melakukan perhitungan matriks tertimbang');
        }
    }

    private function borderForecastAreaMatrix(): void
    {

        try {
            $weightedMatrix = $this->stepData['weightedMatrix'];
            $total_alternative = $this->getAlternatifCount();
            $row = [];
            $G = [];


            for ($i = 0; $i < count($weightedMatrix[1]); $i++) {
                $product = $weightedMatrix[$i][$i];
                for ($j = 0; $j < count($weightedMatrix); $j++) {
                    if ($i == $j) {
                        continue;
                    }
                    $product *= $weightedMatrix[$j][$i];
                }
                $row[] = $this->trimTrailingZeros(number_format(pow($product, 1 / $total_alternative), 3, '.', ''));
            }

            $G[] = $row;

            $this->stepData['borderForecastAreaMatrix'] = $G;
        } catch (\Exception $e) {
            throw new \Exception('Terjadi kesalahan saat melakukan perhitungan matriks perbatasan');
        }

    }

    private function alternativeDistanceMatrix(): void
    {
        try {
            $V = $this->stepData['weightedMatrix'];
            $G = $this->stepData['borderForecastAreaMatrix'];
            $Q = [];

            for ($i = 0; $i < count($V); $i++) {
                $row = [];
                for ($j = 0; $j < count($G[0]); $j++) {
                    $row[] = $this->trimTrailingZeros(number_format($V[$i][$j] - $G[0][$j], 3, '.', ''));
                }
                $Q[] = $row;
            }

            $this->stepData['alternativeDistanceMatrix'] = $Q;
        } catch (\Exception $e) {
            throw new \Exception('Terjadi kesalahan saat melakukan perhitungan matriks jarak alternative');
        }
    }

    private function rankingMatrix(): void
    {
        try {
            $alternative = parent::getAlternatifs();
            $Q = $this->stepData['alternativeDistanceMatrix'];
            $scores = [];
            $S = [];

            for ($i = 0; $i < count($Q); $i++) {
                $row = [];
                $total = 0;
                for ($j = 0; $j < count($Q[0]); $j++) {

                    $total += $Q[$i][$j];

                    $row['Alternatif'] = $alternative[$i];
                    $row['S'] = $this->trimTrailingZeros(number_format($total, 3, '.', ''));
                }

                $scores[] = $total;

                $S[] = $row;
            }

            usort($S, function ($a, $b) {
                return $b['S'] <=> $a['S'];
            });

            foreach ($S as $key => $value) {
                $S[$key]['Ranking'] = $key + 1;
            }

            $this->stepData['rankingMatrix'] = $S;
        } catch (\Exception $e) {
            throw new \Exception('Terjadi kesalahan saat melakukan perankingan');
        }
    }

    private function transposeMatrix($data): array
    {
        try {
            $array = [];
            for ($i = 0; $i < count($data[1]); $i++) {
                $row = [];
                for ($j = 0; $j < count($data); $j++) {
                    $row[] = $data[$j][$i];
                }
                $array[] = $row;
            }

            return $array;
        } catch (\Exception $e) {
            throw new \Exception('Terjadi kesalahan saat melakukan transpose matriks');
        }
    }

    private function getMax(array $data): array
    {
        try {
            $max = [];

            for ($i = 0; $i < count($data); $i++) {
                $max[] = max($data[$i]);
            }

            return $max;
        } catch (\Exception $e) {
            throw new \Exception('Terjadi kesalahan saat mencari nilai maksimum');
        }
    }

    private function getMin(array $data): array
    {
        try {
            $min = [];

            for ($i = 0; $i < count($data); $i++) {
                $min[] = min($data[$i]);
            }

            return $min;
        } catch (\Exception $e) {
            throw new \Exception('Terjadi kesalahan saat mencari nilai minimum');
        }
    }

    private function integerData(): array
    {
        try {
            $convertValueToInteger = function ($value) {
                return (int) $value;
            };

            $integerArray = [];
            foreach (parent::getData() as $key => $subarray) {
                $integerArray[$key] = array_map($convertValueToInteger, $subarray);
            }

            return $integerArray;
        } catch (\Exception $e) {
            throw new \Exception('Terjadi kesalahan saat konversi data ke integer');
        }
    }
}
