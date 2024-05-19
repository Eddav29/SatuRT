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

    private function decisionMatrix(): void
    {
        $this->stepData['decisionMatrix'] = $this->integerData();
    }

    private function normalizeMatrix(): void
    {
        $matrix = $this->transposeMatrix($this->stepData['decisionMatrix']);
        $max = $this->getMax($matrix);
        $min = $this->getMin($matrix);
        $criteriaType = parent::getTipe();
        $X = [];

        for ($i = 0; $i < count($matrix); $i++) {
            $row = [];
            for ($j = 0; $j < count($matrix[1]); $j++) {
                $value = 0;
                if ($criteriaType[$j + 1] === 'Benefit') {
                    $value = $this->trimTrailingZeros(number_format(($this->integerData()[$i + 1][$j + 1] - $min[$j]) / ($max[$j] - $min[$j]), 3, '.', ''));
                } else {
                    $value = $this->trimTrailingZeros(number_format(($this->integerData()[$i + 1][$j + 1] - $max[$j]) / ($min[$j] - $max[$j]), 3, '.', ''));
                }
                $row[] = $value;
            }
            $X[] = $row;
        }

        $this->stepData['normalized'] = $X;
    }

    private function weightedMatrix(): void
    {
        $weight = parent::getBobot();
        $normalizeMatrix = $this->stepData['normalized'];
        $V = [];

        for ($i = 0; $i < count($normalizeMatrix); $i++) {
            $row = [];
            for ($j = 0; $j < count($normalizeMatrix[$i]); $j++) {
                $row[] = $this->trimTrailingZeros(number_format((($weight[$j + 1] / 100) * $normalizeMatrix[$i][$j]) + ($weight[$j + 1] / 100), 3, '.', ''));
            }
            $V[] = $row;
        }

        $this->stepData['weightedMatrix'] = $V;
    }

    private function borderForecastAreaMatrix(): void
    {
        $weightedMatrix = $this->stepData['weightedMatrix'];
        $total_alternative = $this->getAlternatifCount();
        $row = [];
        $G = [];

        for ($i = 0; $i < count($weightedMatrix); $i++) {
            $product = $weightedMatrix[$i][$i];
            for ($j = 0; $j < count($weightedMatrix[$i]); $j++) {
                if ($i == $j) {
                    continue;
                }
                $product *= $weightedMatrix[$j][$i];
            }
            $row[] = $this->trimTrailingZeros(number_format(pow($product, 1 / $total_alternative), 3, '.', ''));
        }

        $G[] = $row;

        $this->stepData['borderForecastAreaMatrix'] = $G;
    }

    private function alternativeDistanceMatrix(): void
    {
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
    }

    private function rankingMatrix(): void
    {
        $alternative = parent::getAlternatifs();
        $Q = $this->stepData['alternativeDistanceMatrix'];
        $scores = [];
        $S = [];

        for ($i = 0; $i < count($Q); $i++) {
            $row = [];
            $total = $Q[$i][$i];
            for ($j = 0; $j < count($Q[$i]); $j++) {
                if ($i == $j) {
                    continue;
                }

                $total += $Q[$i][$j];

                $row['Alternatif'] = $alternative[$i + 1];
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

    private function transposeMatrix($data): array
    {
        $array = [];
        for ($i = 0; $i < count($data); $i++) {
            $row = [];
            for ($j = 0; $j < count($data); $j++) {
                $row[] = $data[$j + 1][$i + 1];
            }
            $array[] = $row;
        }

        return $array;
    }

    private function getMax(array $data): array
    {
        $max = [];

        for ($i = 0; $i < count($data); $i++) {
            $max[] = max($data[$i]);
        }

        return $max;
    }

    private function getMin(array $data): array
    {
        $min = [];

        for ($i = 0; $i < count($data); $i++) {
            $min[] = min($data[$i]);
        }

        return $min;
    }

    private function integerData(): array
    {
        $convertValueToInteger = function ($value) {
            return (int) $value;
        };

        $integerArray = [];
        foreach (parent::getData() as $key => $subarray) {
            $integerArray[$key] = array_map($convertValueToInteger, $subarray);
        }

        return $integerArray;
    }
}
