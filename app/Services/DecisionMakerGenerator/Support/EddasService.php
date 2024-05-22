<?php

namespace App\Services\DecisionMakerGenerator\Support;

use App\Services\DecisionMakerGenerator\DecisionMakerService;

class EddasService extends DecisionMakerService
{
    private array $stepData = [];

    public function __construct(bool $normalize = true)
    {
        parent::__construct($normalize);
        $this->stepData['decisionMatrix'] = parent::getData();
        $this->calculate();
    }

    private function calculate()
    {
        $this->stepDetermineAverange();
        $this->stepDeterminePDA();
        $this->stepDetermineNDA();
        $this->stepDetermineSPSN();
        $this->stepDetermineNormalizeSPSN();
        $this->stepCalculateAssesmentScore();
        $this->stepRanking();
    }

    public function getStepData(): array
    {
        return $this->stepData;
    }

    private function calculatePDA(float $value, float $avg, string $type, int $precision): string
    {
        $pda = ($type === 'Benefit') ? ($value - $avg) / $avg : ($avg - $value) / $avg;
        $trimmedPda = number_format(max(0, $pda), $precision, '.', '');
        return $this->trimTrailingZeros($trimmedPda);
    }

    private function calculateNDA(float $value, float $avg, string $type, int $precision): string
    {
        $nda = ($type === 'Benefit') ? ($avg - $value) / $avg : ($value - $avg) / $avg;
        $trimmedNda = number_format(max(0, $nda), $precision, '.', '');
        return $this->trimTrailingZeros($trimmedNda);
    }

    private function stepDetermineAverange(int $precision = 3)
    {
        $result = [];
        foreach (parent::getKriteria() as $key => $value) {
            $sum = array_sum(array_column(parent::getData(), $key));
            $average = number_format($sum / parent::getAlternatifCount(), $precision, '.', '');
            $result[] = [
                'Kriteria' => 'K' . $key,
                'Averange' => 'AV' . $key,
                'Value' => $this->trimTrailingZeros($average), // Trim trailing zeros using regex
            ];
        }

        $this->stepData['average'] = $result;
    }

    private function stepDeterminePDA(int $precision = 3): void
    {
        $result = [];
        $average = $this->stepData['average'];
        foreach (parent::getData() as $row => $value) {
            foreach ($value as $col => $item) {
                $type = parent::getTipe()[$col];
                $avg = $average[$col]['Value'];
                $pda = $this->calculatePDA($value[$col], $avg, $type, $precision);
                $result[$row][$col] = $pda;
            }
        }

        $this->stepData['pda_nda']['pda'] = $result;
    }

    private function stepDetermineNDA(int $precision = 3): void
    {
        $result = [];
        $average = $this->stepData['average'];
        foreach (parent::getData() as $row => $value) {
            foreach ($value as $col => $item) {
                $type = parent::getTipe()[$col];
                $avg = $average[$col]['Value'];
                $nda = $this->calculateNDA($value[$col], $avg, $type, $precision);
                $result[$row][$col] = $nda;
            }
        }

        $this->stepData['pda_nda']['nda'] = $result;
    }

    private function stepDetermineSPSN(int $precision = 3): void
    {
        $result = [];
        $pda = $this->stepData['pda_nda']['pda'];
        $nda = $this->stepData['pda_nda']['nda'];
        foreach ($pda as $row => $value) {
            $sp = 0;
            $sn = 0;
            foreach ($value as $col => $item) {
                $weight = parent::getBobot()[$col];
                $sp += $pda[$row][$col] * $weight;
                $sn += $nda[$row][$col] * $weight;
            }
            $result[] = [
                'Alternatif' => 'A' . $row,
                'SP' => $this->trimTrailingZeros(number_format($sp, $precision, '.', '')),
                'SN' => $this->trimTrailingZeros(number_format($sn, $precision, '.', '')),
            ];
        }

        $this->stepData['spsn'] = $result;
    }

    private function stepDetermineNormalizeSPSN(int $precision = 3): void
    {
        $result = [];
        $spsn = $this->stepData['spsn'];
        $maxSP = max(array_column($spsn, 'SP'));
        $maxSN = max(array_column($spsn, 'SN'));
        foreach ($spsn as $value) {
            $result[] = [
                'Alternatif' => $value['Alternatif'],
                'NSP' => $this->trimTrailingZeros(number_format($value['SP'] / $maxSP, $precision, '.', '')),
                'NSN' => $this->trimTrailingZeros(number_format(1 - $value['SN'] / $maxSN, $precision, '.', '')),
            ];
        }

        $this->stepData['nspnsn'] = $result;
    }

    private function stepCalculateAssesmentScore(int $precision = 3): void
    {
        $result = [];
        $spsn = $this->stepData['nspnsn'];
        foreach ($spsn as $value) {
            $result[] = [
                'Alternatif' => $value['Alternatif'],
                'AS' => $this->trimTrailingZeros(number_format($value['NSP'] * 0.5 + $value['NSN'] * 0.5, $precision, '.', '')),
            ];
        }

        $this->stepData['AS'] = $result;
    }

    private function stepRanking(int $precision = 3): void
    {
        $result = [];
        $score = $this->stepData['AS'];

        usort($score, function ($a, $b) {
            return $b['AS'] <=> $a['AS'];
        });
        foreach ($score as $key => $value) {
            $value['Alternatif'] = parent::getAlternatifNama(parent::removeAlias($value['Alternatif']));
            $value['Ranking'] = $key + 1;
            $result[] = $value;
        }

        $this->stepData['ranking'] = $result;
    }
}
