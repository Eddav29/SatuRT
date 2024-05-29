<?php
namespace App\Services\DecisionMakerGenerator\Support;

use App\Services\DecisionMakerGenerator\DecisionMakerService;
use Exception;

class ArasService extends DecisionMakerService
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
        $this->decisionMatrix();
        $this->normalizeMatrix();
        $this->weightedNormalization();
        $this->optimumValueSearch();
        $this->utilityRanking();
    }

    private function decisionMatrix()
    {
        $matrix = $this->stepData['decisionMatrix'];
        $a0 = $this->calculateA0($matrix);
        array_unshift($matrix, $a0);
        for ($i = 1; $i < count($matrix); $i++) {
            array_unshift($matrix[$i], 'A' . $i);
        }
        $this->stepData['decisionMatrix1'] = $matrix;
    }

    public function calculateA0(array $matrix): array
    {
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
    }

    public function getMax(array $matrix): array
    {
        $transposed = array_map(null, ...$matrix);
        return array_map('max', $transposed);
    }

    public function getMin(array $matrix): array
    {
        $transposed = array_map(null, ...$matrix);
        return array_map('min', $transposed);
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

                        if ($criteriaType[$colIndex-1] == 'Cost') {
                            // Normalize for cost criteria
                            $R[$rowIndex][$colIndex] = $this->trimTrailingZeros(number_format($value / $sum_j[$colIndex], 3, '.', ''));
                        } else {
                            // Normalize for benefit criteria
                            $R[$rowIndex][$colIndex] = $this->trimTrailingZeros(number_format($value / $sum_j[$colIndex], 3, '.', ''));
                        }
                    }
                }
            }

            // Save the normalized matrix in stepData
            $this->stepData['normalizedMatrix'] = $R;
        } catch (\Throwable $th) {
            abort("Terjadi kesalahan dalam proses Normalisasi Matriks");
        }
    }


    public function weightedNormalization()
    {
        try {
            if (!isset($this->stepData['normalizedMatrix'])) {
                throw new Exception('Normalized matrix is not set in stepData.');
            }

            $normalizedMatrix = $this->stepData['normalizedMatrix'];
            $weights = parent::getBobot();

            // Validate that weights array has enough entries for each column in normalizedMatrix
            if (count($weights) < count($normalizedMatrix[0]) - 1) {
                throw new Exception('Weights array is smaller than the number of columns in the normalized matrix.');
            }

            $weightedMatrix = [];
            foreach ($normalizedMatrix as $row) {
                $weightedRow = [$row[0]]; // Copy the identifier column as is
                for ($i = 1; $i < count($row); $i++) {
                    if (!isset($weights[$i - 1])) {
                        throw new Exception("Undefined weight for column index $i");
                    }
                    $weightedRow[] = $row[$i] * $weights[$i - 1];
                }
                $weightedMatrix[] = $weightedRow;
            }

            $this->stepData['weightedMatrix'] = $weightedMatrix;

        } catch (\Throwable $th) {
            abort("Terjadi kesalahan dalam proses Pembobotan Matriks Normalisasi");
        }
    }

    public function optimumValueSearch()
    {
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
    }

    public function utilityRanking(int $precision = 3): void
    {
        try {
            $siValues = $this->stepData['siValues'];

            if (!empty($siValues)) {
                $a0 = $siValues[0]['Si'];
                $kValues = [];

                foreach ($siValues as $siValue) {
                    if ($siValue['Alternatif'] !== 'A0') {
                        $alternatifIndex = (int) substr($siValue['Alternatif'], 1); // Extract index from 'A1', 'A2', etc.
                        $si = $siValue['Si'];
                        $k = $si / $a0;
                        $kValues[] = [
                            'Alternatif' => $alternatifIndex, // Store the alternative index
                            'K' => $k,
                        ];
                    }
                }

                usort($kValues, function ($a, $b) {
                    return $b['K'] <=> $a['K']; // Sort in descending order of 'K'
                });

                $alternatifs = parent::getAlternatifs(); // Get array of alternatives from parent
                $rankedAlternatives = [];
                $rank = 1;

                foreach ($kValues as $kValue) {
                    $alternatifIndex = $kValue['Alternatif']; // Get the alternative index from calculated results
                    $alternatif = $alternatifs[$alternatifIndex - 1] ?? ''; // Adjust for zero-based index, use empty string if not found
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
        } catch (\Throwable $th) {
            abort("Terjadi Kesalahan dalam proses Perankingan");
        }
    }

    public function convert_cost_value()
    {
        $matrix = $this->stepData['decisionMatrix1'];
        $criteriaType = parent::getTipe();

        for ($i = 0; $i < count($matrix); $i++) {
            for ($j = 1; $j < count($matrix[$i]); $j++) { // Start from 1 to skip the identifier column
                if ($criteriaType[$j - 1] == 'Cost') { // Adjust index for criteriaType
                    $matrix[$i][$j] = $this->trimTrailingZeros(number_format(1 / $matrix[$i][$j], 3, '.', ''));
                }
            }
        }

        return $matrix;
    }
}
