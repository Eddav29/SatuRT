<?php

namespace App\Services\DecisionMakerGenerator\Support;

use App\Services\DecisionMakerGenerator\DecisionMakerService;
use Exception;

class ElectreService extends DecisionMakerService
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

    private function calculate()
    {
        $this->stepNormalizationR();
        $this->stepWeightedNormalizationR();
        $this->stepSetConcordanceMatrix();
        $this->stepSetDiscordanceMatrix();
        $this->stepDetermineMatrixConcordance();
        $this->stepDetermineMatrixDiscordance();
        $this->stepCalculateThresholdMatrixConcordance();
        $this->stepCalculateThresholdMatrixDiscordance();
        $this->stepCalculatMatrixDominantConcordance();
        $this->stepCalculatMatrixDominantDiscordance();
        $this->stepDetermineAggregateMatrix();
        $this->stepElimination();
        $this->stepRanking();
    }

    public function stepNormalizationR($precision = 3)
    {
        try {
            $decisionMatrix = $this->stepData['decisionMatrix'];
            $normalizationR = [];
            foreach (parent::getKriteria() as $key => $value) {
                $sqrt = sqrt(array_sum(array_map(function ($row) use ($key) {
                    return pow($row[$key], 2);
                }, parent::getData())));
                foreach ($decisionMatrix as $rowKey => $rowValue) {
                    $normalizationR[$rowKey][$key] = parent::trimTrailingZeros(number_format($rowValue[$key] / $sqrt, $precision, '.', ''));
                }
            }
            $this->stepData['normalizationR'] = $normalizationR;
        } catch (\Exception $e) {
            throw new Exception('Terjadi kesalahan saat melakukan normalisasi R');
        }
    }

    public function stepWeightedNormalizationR($precision = 3)
    {
        try {
            $normalizationR = $this->stepData['normalizationR'];
            $weightedNormalizationR = [];
            foreach (parent::getKriteria() as $key => $value) {
                $weight = parent::getBobotValue($key);
                foreach ($normalizationR as $rowKey => $rowValue) {
                    $weightedNormalizationR[$rowKey][$key] = parent::trimTrailingZeros(number_format($rowValue[$key] * $weight, $precision, '.', ''));
                }
            }
            $this->stepData['weightedNormalizationR'] = $weightedNormalizationR;
        } catch (\Exception $e) {
            throw new Exception('Terjadi kesalahan saat melakukan perhitungan normalisasi R berbobot');
        }
    }

    public function stepSetConcordanceMatrix()
    {
        try {
            $weightedNormalizationR = $this->stepData['weightedNormalizationR'];
            $indexCriteria = [];
            foreach ($weightedNormalizationR as $i => $rowI) {
                foreach ($weightedNormalizationR as $j => $rowJ) {
                    if ($i !== $j) {
                        $result = [];
                        $index = [];
                        foreach ($rowI as $k => $valueI) {
                            $result[$k] = ($valueI >= $rowJ[$k]) ? 1 : 0;
                            if ($valueI >= $rowJ[$k]) {
                                $index[] = $k + 1;
                            }
                        }
                        $concordanceMatrix['C' . ($i + 1) . ($j + 1)] = $result;
                        $indexCriteria[] = [
                            'Kriteria' => 'C' . ($i + 1) . ($j + 1),
                            'Index' => implode(',', $index)
                        ];
                    }
                }
            }
            $this->stepData['indexCriteria']['Concordance'] = $indexCriteria;
            $this->stepData['helperConcordanceMatrix'] = $concordanceMatrix;
        } catch (\Exception $e) {
            throw new Exception('Terjadi kesalahan saat melakukan perhitungan matriks Concordance');
        }
    }

    public function stepSetDiscordanceMatrix()
    {
        try {
            $weightedNormalizationR = $this->stepData['weightedNormalizationR'];
            $indexCriteria = [];
            foreach ($weightedNormalizationR as $i => $rowI) {
                foreach ($weightedNormalizationR as $j => $rowJ) {
                    if ($i !== $j) {
                        $result = [];
                        $index = [];
                        foreach ($rowI as $k => $valueI) {
                            $result[$k] = ($valueI < $rowJ[$k]) ? 1 : 0;
                            if ($valueI < $rowJ[$k]) {
                                $index[] = $k + 1;
                            }
                        }
                        $discordanceMatrix['D' . ($i + 1) . ($j + 1)] = $result;
                        $indexCriteria[] = [
                            'Kriteria' => 'D' . ($i + 1) . ($j + 1),
                            'Index' => implode(',', $index)
                        ];
                    }
                }
            }
            $this->stepData['indexCriteria']['Discordance'] = $indexCriteria;
            $this->stepData['helperDiscordanceMatrix'] = $discordanceMatrix;
        } catch (\Exception $e) {
            throw new Exception('Terjadi kesalahan saat melakukan perhitungan matriks Discordance');
        }
    }

    public function stepDetermineMatrixConcordance()
    {
        try {
            $concordanceMatrix = $this->stepData['helperConcordanceMatrix'];
            $weightedNormalizationR = $this->stepData['weightedNormalizationR'];
            $matrixConcordance = [];
            foreach ($weightedNormalizationR as $i => $rowI) {
                foreach ($weightedNormalizationR as $j => $rowJ) {
                    if ($i !== $j) {
                        $result = 0;
                        foreach ($rowI as $k => $valueI) {
                            $result += ($concordanceMatrix['C' . ($i + 1) . ($j + 1)][$k] === 1) ? parent::getBobotValue($k) : 0;
                        }
                        $matrixConcordance[$i][$j] = $result;
                    } else {
                        $matrixConcordance[$i][$j] = '-';
                    }
                }
            }
            $this->stepData['matrixConcordance']['C'] = $matrixConcordance;
        } catch (\Exception $e) {
            throw new Exception('Terjadi kesalahan saat melakukan menentukan matriks Concordance');
        }
    }

    public function stepDetermineMatrixDiscordance($precision = 3)
    {
        try {
            $discordanceMatrix = $this->stepData['helperDiscordanceMatrix'];
            $weightedNormalizationR = $this->stepData['weightedNormalizationR'];
            $matrixDiscordance = [];
            foreach ($weightedNormalizationR as $i => $rowI) {
                foreach ($weightedNormalizationR as $j => $rowJ) {
                    if ($i !== $j) {
                        $pembilang = [];
                        $penyebut = [];
                        foreach ($rowI as $k => $valueI) {
                            if ($discordanceMatrix['D' . ($i + 1) . ($j + 1)][$k] === 1) {
                                $pembilang[] = ($discordanceMatrix['D' . ($i + 1) . ($j + 1)][$k] === 1) ? abs($rowI[$k] - $rowJ[$k]) : 0;
                            } else {
                                $pembilang[] = 0;
                            }
                            $penyebut[] = abs($rowI[$k] - $rowJ[$k]);
                        }
                        $matrixDiscordance[$i][$j] = parent::trimTrailingZeros(number_format(max($pembilang) / max($penyebut), $precision, '.', ''));
                    } else {
                        $matrixDiscordance[$i][$j] = '-';
                    }
                }
            }
            $this->stepData['matrixDiscordance']['D'] = $matrixDiscordance;
        } catch (\Exception $e) {
            throw new Exception('Terjadi kesalahan saat melakukan menentukan matriks Discordance');
        }
    }

    public function stepCalculateThresholdMatrixConcordance($precision = 3)
    {
        try {
            $matrixConcordance = $this->stepData['matrixConcordance']['C'];
            $matrixConcordanceResult = 0;
            foreach ($matrixConcordance as $i => $rowI) {
                foreach ($rowI as $j => $value) {
                    if ($i !== $j) {
                        $matrixConcordanceResult += $value;
                    }
                }
            }
            $this->stepData['thresholdMatrixConcordance'][][] = parent::trimTrailingZeros(number_format($matrixConcordanceResult / ((count($matrixConcordance) * (count($matrixConcordance) - 1))), $precision, '.', ''));
        } catch (\Exception $e) {
            throw new Exception('Terjadi kesalahan saat melakukan perhitungan threshold matriks Concordance');
        }
    }

    public function stepCalculateThresholdMatrixDiscordance($precision = 3)
    {
        try {
            $matrixDiscordance = $this->stepData['matrixDiscordance']['D'];
            $matrixDiscordanceResult = 0;
            foreach ($matrixDiscordance as $i => $rowI) {
                foreach ($rowI as $j => $value) {
                    if ($i !== $j) {
                        $matrixDiscordanceResult += $value;
                    }
                }
            }
            $this->stepData['thresholdMatrixDiscordance'][][] = parent::trimTrailingZeros(number_format($matrixDiscordanceResult / ((count($matrixDiscordance) * (count($matrixDiscordance) - 1))), $precision, '.', ''));
        } catch (\Exception $e) {
            throw new Exception('Terjadi kesalahan saat melakukan perhitungan threshold matriks Discordance');
        }
    }

    public function stepCalculatMatrixDominantConcordance()
    {
        try {
            $matrixConcordance = $this->stepData['matrixConcordance']['C'];
            $thresholdMatrixConcordance = $this->stepData['thresholdMatrixConcordance'][0][0];
            foreach ($matrixConcordance as $i => $rowI) {
                foreach ($rowI as $j => $value) {
                    if ($i !== $j) {
                        $matrixDominantConcordance[$i][$j] = ($value >= $thresholdMatrixConcordance) ? 1 : 0;
                    } else {
                        $matrixDominantConcordance[$i][$j] = '-';
                    }
                }
            }
            $this->stepData['matrixDominantConcordance']['F'] = $matrixDominantConcordance;
        } catch (\Exception $e) {
            throw new Exception('Terjadi kesalahan saat melakukan perhitungan matriks Dominant Concordance');
        }
    }

    public function stepCalculatMatrixDominantDiscordance()
    {
        try {
            $matrixDiscordance = $this->stepData['matrixDiscordance']['D'];
            $thresholdMatrixDiscordance = $this->stepData['thresholdMatrixDiscordance'][0][0];
            foreach ($matrixDiscordance as $i => $rowI) {
                foreach ($rowI as $j => $value) {
                    if ($i !== $j) {
                        $matrixDominantDiscordance[$i][$j] = ($value >= $thresholdMatrixDiscordance) ? 1 : 0;
                    } else {
                        $matrixDominantDiscordance[$i][$j] = '-';
                    }
                }
            }
            $this->stepData['matrixDominantDiscordance']['G'] = $matrixDominantDiscordance;
        } catch (\Exception $e) {
            throw new Exception('Terjadi kesalahan saat melakukan perhitungan matriks Dominant Discordance');
        }
    }


    // public function stepDetermineAggregateMatrix()
    // {
    //     try {
    //         $matrixDominantConcordance = $this->stepData['matrixDominantConcordance']['F'];
    //         $matrixDominantDiscordance = $this->stepData['matrixDominantDiscordance']['G'];
    //         $aggregateMatrix = [];
    //         foreach ($matrixDominantConcordance as $i => $rowI) {
    //             foreach ($rowI as $j => $value) {
    //                 if ($i !== $j) {
    //                     $aggregateMatrix[$i][$j] = ($matrixDominantConcordance[$i][$j] === 1 && $matrixDominantDiscordance[$i][$j] === 1) ? 1 : 0;
    //                 } else {
    //                     $aggregateMatrix[$i][$j] = '-';
    //                 }
    //             }
    //         }
    //         $this->stepData['aggregateMatrix']['E'] = $aggregateMatrix;
    //     } catch (\Exception $e) {
    //         throw new Exception('Terjadi kesalahan saat melakukan menentukan matriks Aggregate');
    //     }
    // }

    public function stepDetermineAggregateMatrix()
    {
        try {
            $matrixDominantConcordance = $this->stepData['matrixDominantConcordance']['F'];
            $matrixDominantDiscordance = $this->stepData['matrixDominantDiscordance']['G'];
            $aggregateMatrix = [];
            foreach ($matrixDominantConcordance as $i => $rowI) {
                $totalOnes = 0; // Initialize the counter for 1s in the row
                foreach ($rowI as $j => $value) {
                    if ($i !== $j) {
                        $aggregateMatrix[$i][$j] = ($matrixDominantConcordance[$i][$j] === 1 && $matrixDominantDiscordance[$i][$j] === 1) ? 1 : 0;
                        if ($aggregateMatrix[$i][$j] === 1) {
                            $totalOnes++; // Increment the counter if the value is 1
                        }
                    } else {
                        $aggregateMatrix[$i][$j] = '-';
                    }
                }
                $aggregateMatrix[$i]['Total'] = $totalOnes; // Store the total count of 1s in the new column
            }
            $this->stepData['aggregateMatrix']['E'] = $aggregateMatrix;
        } catch (\Exception $e) {
            throw new Exception('Terjadi kesalahan saat melakukan menentukan matriks Aggregate');
        }
    }


    // public function stepRanking($precision = 3)
    // {
    //     try {
    //         $matrixConcordance = $this->stepData['matrixConcordance']['C'];
    //         $matrixDiscordance = $this->stepData['matrixDiscordance']['D'];

    //         $ranking = [];

    //         foreach ($matrixConcordance as $i => $rowI) {
    //             $result = 0;
    //             foreach ($rowI as $j => $value) {
    //                 $result += ($i !== $j) ? $matrixConcordance[$i][$j] - $matrixDiscordance[$i][$j] : 0;
    //             }
    //             $ranking[$i] = [
    //                 'Alternatif' => parent::getAlternatifNama($i),
    //                 'E' => parent::trimTrailingZeros(number_format($result, $precision, '.', '')),
    //             ];
    //         }

    //         usort($ranking, function ($a, $b) {
    //             return $b['E'] <=> $a['E'];
    //         });

    //         foreach ($ranking as $key => $value) {
    //             $value['Ranking'] = $key + 1;
    //             $ranking[$key] = $value;
    //         }

    //         $this->stepData['ranking'] = $ranking;
    //     } catch (\Exception $e) {
    //         throw new Exception('Terjadi kesalahan saat melakukan perhitungan ranking');
    //     }
    // }


    public function stepElimination($precision = 3)
    {
        try {
            $matrixConcordance = $this->stepData['matrixConcordance']['C'];
            $matrixDiscordance = $this->stepData['matrixDiscordance']['D'];

            $elimination = [];

            foreach ($matrixConcordance as $i => $rowI) {
                $result = 0;
                foreach ($rowI as $j => $value) {
                    $result += ($i !== $j) ? $matrixConcordance[$i][$j] - $matrixDiscordance[$i][$j] : 0;
                }
                $elimination[$i] = [
                    'Alternatif' => parent::getAlternatifNama($i),
                    'E' => parent::trimTrailingZeros(number_format($result, $precision, '.', '')),
                ];
            }

            usort($elimination, function ($a, $b) {
                return $b['E'] <=> $a['E'];
            });

            foreach ($elimination as $key => $value) {
                $value['Ranking'] = $key + 1;
                $elimination[$key] = $value;
            }

            $this->stepData['elimination'] = $elimination;
        } catch (\Exception $e) {
            throw new Exception('Terjadi kesalahan saat melakukan perhitungan elimination');
        }
    }

    public function stepRanking()
    {
        // try {
            $stepAgregateMatrix = $this->stepData['aggregateMatrix']['E'];
            $isAgree = false;

            foreach ($stepAgregateMatrix as $key => $value) {
                if ($value['Total'] >= 1) {
                    $isAgree = true;
                    break;
                }
            }

            if ($isAgree) {


                foreach ($stepAgregateMatrix as $i => $rowI) {
                    $ranking[$i] = [
                        'Alternatif' => parent::getAlternatifNama($i),
                        'Total' => $stepAgregateMatrix[$i]['Total'],
                    ];
                }

                usort($ranking, function ($a, $b) {
                    return $b['Total'] <=> $a['Total'];
                });

                foreach ($ranking as $key => $value) {
                    $value['Ranking'] = $key + 1;
                    $ranking[$key] = $value;
                }

                $this->stepData['ranking'] = $ranking;
            // $this->stepData['ranking'] = $this->stepData['elimination'];
            } else {
                $this->stepData['ranking'] = $this->stepData['elimination'];
            }
        // } catch (\Exception $e) {
        //     throw new Exception('Terjadi kesalahan saat melakukan perhitungan ranking Electre');
        // }
    }
}
