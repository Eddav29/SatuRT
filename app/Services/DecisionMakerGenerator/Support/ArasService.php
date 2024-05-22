<?php
namespace App\Services\DecisionMakerGenerator\Support;

use App\Services\Notification\NotificationPusher;
use App\Services\DecisionMakerGenerator\DecisionMakerService;

class ArasService extends DecisionMakerService
{
    private array $stepData = [];

    public function __construct(bool $normalize = true)
    {
        try {
            parent::__construct($normalize);
            $this->stepData['decisionMatrix'] = parent::getData();
            $this->calculate();
        } catch (\Exception $e) {
            NotificationPusher::error('data tidak berhasil dihitung');
            exit;
        }
    }

    public function getStepData(): array
    {
        try {
            return $this->stepData;
        } catch (\Exception $e) {
            NotificationPusher::error('data tidak berhasil dihitung');
            exit;
        }
    }

    private function calculate()
    {
        try {
            $this->decisionMatrix();
            $this->normalizeMatrix();
            $this->weightedNormalization();
            $this->optimumValueSearch();
            $this->utilityRanking();
        } catch (\Exception $e) {
            NotificationPusher::error('data tidak berhasil dihitung');
            exit;
        }
    }

    private function decisionMatrix()
    {
        try {
            $matrix = $this->stepData['decisionMatrix'];
            $a0 = $this->calculateA0($matrix);
            array_unshift($matrix, $a0);
            for ($i = 1; $i < count($matrix); $i++) {
                array_unshift($matrix[$i], 'A' . $i);
            }
            $this->stepData['decisionMatrix1'] = $matrix;
        } catch (\Exception $e) {
            NotificationPusher::error('data tidak berhasil dihitung');
            exit;
        }
    }

    public function calculateA0(array $matrix): array
    {
        try {
            $max = $this->getMax($matrix);
            $min = $this->getMin($matrix);
            $criteriaType = parent::getTipe();
            $a0 = [
                0 => "A0",
                1 => $max[0],
                2 => $max[1],
                3 => $max[2],
                4 => $min[3],
                5 => $min[4],
            ];

            return $a0;
        } catch (\Exception $e) {
            NotificationPusher::error('data tidak berhasil dihitung');
            exit;
        }
    }

    public function getMax(array $matrix): array
    {
        try {
            $transposed = array_map(null, ...$matrix);
            return array_map('max', $transposed);
        } catch (\Exception $e) {
            NotificationPusher::error('data tidak berhasil dihitung');
            exit;
        }
    }

    public function getMin(array $matrix): array
    {
        try {
            $transposed = array_map(null, ...$matrix);
            return array_map('min', $transposed);
        } catch (\Exception $e) {
            NotificationPusher::error('data tidak berhasil dihitung');
            exit;
        }
    }

    public function normalizeMatrix()
    {
        try {
            $matrix = $this->convert_cost_value();
            $criteriaType = parent::getTipe();

            // Initialize sum arrays for benefit and cost criteria
            $sum_j = [];

            // Calculate sum of values for benefit and inverse sum for cost
            foreach ($matrix as $row) {
                foreach ($row as $colIndex => $value) {
                    if ($colIndex === 0) continue; // Skip the identifier column
                    if (!isset($sum_j[$colIndex])) $sum_j[$colIndex] = 0;
                    $sum_j[$colIndex] += $value;
                }
            }

            // Initialize the normalized matrix
            $R = [];

            foreach ($matrix as $rowIndex => $row) {
                $R[$rowIndex] = []; // Initialize the row in the normalized matrix

                foreach ($row as $colIndex => $value) {
                    if ($colIndex === 0) {
                        // Copy the identifier column as is
                        $R[$rowIndex][$colIndex] = $value;
                    } else {
                        if ($criteriaType[$colIndex] == 'Cost') {
                            // Normalize for cost criteria
                            $R[$rowIndex][$colIndex] = $this->trimTrailingZeros(number_format(($value) / $sum_j[$colIndex], 3, '.', ''));
                        } else {
                            // Normalize for benefit criteria
                            $R[$rowIndex][$colIndex] = $this->trimTrailingZeros(number_format($value / $sum_j[$colIndex], 3, '.', ''));
                        }
                    }
                }
            }

            // Save the normalized matrix in stepData
            $this->stepData['normalizedMatrix'] = $R;
        } catch (\Exception $e) {
            NotificationPusher::error('data tidak berhasil dihitung');
            exit;
        }
    }

    public function weightedNormalization()
    {
        try {
            $normalizedMatrix = $this->stepData['normalizedMatrix'];
            $weights = parent::getBobot();

            $weightedMatrix = [];
            foreach ($normalizedMatrix as $row) {
                $weightedRow = [$row[0]];
                for ($i = 1; $i < count($row); $i++) {
                    $weightedRow[] = $row[$i] * $weights[$i];
                }
                $weightedMatrix[] = $weightedRow;
            }

            $this->stepData['weightedMatrix'] = $weightedMatrix;
        } catch (\Exception $e) {
            NotificationPusher::error('data tidak berhasil dihitung');
            exit;
        }
    }

    public function optimumValueSearch()
    {
        try {
            $weightedMatrix = $this->stepData['weightedMatrix'];
            $siValues = [];

            foreach ($weightedMatrix as $row) {
                $identifier = $row[0];
                $si = array_sum(array_slice($row, 1)); // Hitung nilai fungsi optimum (Si) untuk setiap baris matriks
                $siValues[] = [
                    'Alternatif' => $identifier,
                    'Si' => $si, // Gunakan $si langsung, bukan $this->$si
                ];
            }

            $this->stepData['siValues'] = $siValues;
        } catch (\Exception $e) {
            NotificationPusher::error('data tidak berhasil dihitung');
            exit;
        }
    }

    public function utilityRanking(int $precision = 3): void
    {
        try {
            $siValues = $this->stepData['siValues'];
            if (!empty($siValues)) { // Pastikan array $siValues tidak kosong
                $a0 = $siValues[0]['Si'];
                $kValues = [];
                foreach ($siValues as $siValue) {
                    if ($siValue['Alternatif'] !== 'A0') {
                        $alternatifIndex = (int) substr($siValue['Alternatif'], 1); // Mengambil indeks dari string 'A1', 'A2', dll.
                        $si = $siValue['Si'];
                        $k = $si / $a0;
                        $kValues[] = [
                            'Alternatif' => $alternatifIndex, // Simpan indeks alternatif
                            'K' => $k,
                        ];
                    }
                }

                usort($kValues, function ($a, $b) {
                    return $b['K'] <=> $a['K'];
                });

                $alternatifs = parent::getAlternatifs(); // Ambil array alternatif dari parent
                $rankedAlternatives = [];
                $rank = 1;
                foreach ($kValues as $kValue) {
                    $alternatifIndex = $kValue['Alternatif']; // Ambil indeks alternatif dari hasil perhitungan
                    $alternatif = $alternatifs[$alternatifIndex] ?? ''; // Gunakan alternatif jika ada, jika tidak, gunakan string kosong
                    $k = $kValue['K'];
                    $rankedAlternatives[] = [
                        'Alternatif' => $alternatif,
                        'K' => $this->trimTrailingZeros(number_format($k, $precision, '.', '')),
                        'Ranking' => $rank,
                    ];
                    $rank++;
                }

                $this->stepData['utilityRanking'] = $rankedAlternatives;
            }
        } catch (\Exception $e) {
            NotificationPusher::error('data tidak berhasil dihitung');
            exit;
        }
    }

    public function convert_cost_value()
    {
        try {
            $matrix = $this->stepData['decisionMatrix1'];
            $criteriaType = parent::getTipe();

            for ($i = 0; $i < count($matrix); $i++) {
                for ($j = 0; $j < count($matrix[$i]); $j++) {
                    if ($j != 0) {
                        if ($criteriaType[$j] == 'Cost') {
                            $matrix[$i][$j] = $this->trimTrailingZeros(number_format(1 / $matrix[$i][$j], 3, '.', ''));
                        }
                    }
                }
            }

            return $matrix;
        } catch (\Exception $e) {
            NotificationPusher::error('data tidak berhasil dihitung');
            exit;
        }
    }
}
