<?php

namespace App\Services\DecisionMakerGenerator\Support;

use App\Services\DecisionMakerGenerator\DecisionMakerService;

class SmartService extends DecisionMakerService
{
    private array $stepData = [];

    public function __construct()
    {
        parent::__construct(false);
        $this->calculate();
    }

    public function getStepData(): array
    {
        return $this->stepData;
    }

    private function calculate(): void
    {
        $this->decisionMatrix();
        $this->normalizeMatrix();
        $this->unityMatrix();
        $this->getRanking();
    }

    private function decisionMatrix()
    {
        $this->stepData['decisionMatrix'] = parent::getData();
    }

    private function normalizeMatrix()
    {
        try {
            $criterias = parent::getKriteria();
            $weight = parent::getBobot();
            $total_weight = array_sum($weight);

            $normalizeMatrix = [];

            foreach ($criterias as $key => $value) {
                $row = [];
                $row[] = 'C' . $key + 1;
                $row[] = $value;
                $row[] = $weight[$key];
                $row[] = $this->trimTrailingZeros(number_format($weight[$key] / $total_weight, 3, '.', ''));
                $normalizeMatrix[] = $row;
            }

            $this->stepData['normalizeMatrix'] = $normalizeMatrix;
        } catch (\Exception $e) {
            throw new \Exception('Terjadi kesalahan saat melakukan normalisasi matriks');
        }
    }

    private function unityMatrix()
    {
        try {
            $criteria_type = parent::getTipe();
            $data = parent::getData();
            $transpose_data = $this->transposeMatrix($data);
            $min = $this->getMin($transpose_data);
            $max = $this->getMax($transpose_data);
            $unityMatrix = [];

            foreach ($data as $key => $value) {
                $row = [];
                foreach ($value as $key2 => $value2) {
                    if ($criteria_type[$key2] == 'Benefit') {
                        $row[] = $this->trimTrailingZeros(number_format(($value2 - $min[$key2]) / ($max[$key2] - $min[$key2]), 3, '.', ''));
                    } else {
                        $row[] = $this->trimTrailingZeros(number_format(($max[$key2] - $value2) / ($max[$key2] - $min[$key2]), 3, '.', ''));
                    }
                }
                $unityMatrix[] = $row;
            }

            $this->stepData['unityMatrix'] = $unityMatrix;
        } catch (\Exception $e) {
            throw new \Exception('Terjadi kesalahan saat melakukan normalisasi matriks');
        }
    }

    private function getRanking()
    {
        try {
            $normalizeMatrix = $this->stepData['normalizeMatrix'];
            $alternatives = parent::getAlternatifs();
            $data = $this->stepData['unityMatrix'];
            $matrix = [];


            foreach ($data as $key => $value) {
                $row = [];
                $score = [];

                foreach ($value as $key2 => $value2) {
                    $score[] = $this->trimTrailingZeros(number_format($value2 * $normalizeMatrix[$key2][3], 3, '.', ''));
                }

                $row['Alternatif'] = $alternatives[$key];
                $row['S'] = $this->trimTrailingZeros(number_format(array_sum($score), 3, '.', ''));
                $matrix[] = $row;
            }

            usort($matrix, function ($a, $b) {
                return $b['S'] <=> $a['S'];
            });

            foreach ($matrix as $key => $value) {
                $matrix[$key]['Ranking'] = $key + 1;
            }

            $this->stepData['ranking'] = $matrix;
        } catch (\Exception $e) {
            throw new \Exception('Terjadi kesalahan saat mencari ranking');
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
}