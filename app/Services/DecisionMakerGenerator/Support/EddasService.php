<?php

namespace App\Services\DecisionMakerGenerator\Support;

use App\Services\DecisionMakerGenerator\DecisionMakerService;

class EddasService extends DecisionMakerService
{
    public function __construct(bool $normalize = true)
    {
        parent::__construct($normalize);
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

    public function stepDetermineAverange(int $precision = 3)
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
        return $result;
    }

    public function stepDeterminePDA(int $precision = 3)
    {
        $result = [];
        $average = $this->stepDetermineAverange();
        foreach (parent::getData() as $row => $value) {
            foreach ($value as $col => $item) {
                $type = parent::getTipe()[$col];
                $avg = $average[$col - 1]['Value'];
                $pda = $this->calculatePDA($value[$col], $avg, $type, $precision);
                $result[$row][$col] = $pda;
            }
        }
        return $result;
    }

    public function stepDetermineNDA(int $precision = 3)
    {
        $result = [];
        $average = $this->stepDetermineAverange();
        foreach (parent::getData() as $row => $value) {
            foreach ($value as $col => $item) {
                $type = parent::getTipe()[$col];
                $avg = $average[$col - 1]['Value'];
                $nda = $this->calculateNDA($value[$col], $avg, $type, $precision);
                $result[$row][$col] = $nda;
            }
        }
        return $result;
    }

    public function stepDetermineSPSN(int $precision = 3)
    {
        $result = [];
        $pda = $this->stepDeterminePDA($precision);
        $nda = $this->stepDetermineNDA($precision);
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
        return $result;
    }

    public function stepDetermineNormalizeSPSN(int $precision = 3)
    {
        $result = [];
        $spsn = $this->stepDetermineSPSN($precision);
        $maxSP = max(array_column($spsn, 'SP'));
        $maxSN = max(array_column($spsn, 'SN'));
        foreach ($spsn as $value) {
            $result[] = [
                'Alternatif' => $value['Alternatif'],
                'NSP' => $this->trimTrailingZeros(number_format($value['SP'] / $maxSP, $precision, '.', '')),
                'NSN' => $this->trimTrailingZeros(number_format(1 - $value['SN'] / $maxSN, $precision, '.', '')),
            ];
        }
        return $result;
    }

    public function stepCalculateAssesmentScore(int $precision = 3)
    {
        $result = [];
        $spsn = $this->stepDetermineNormalizeSPSN();
        foreach ($spsn as $value) {
            $result[] = [
                'Alternatif' => $value['Alternatif'],
                'AS' => $this->trimTrailingZeros(number_format($value['NSP'] * 0.5 + $value['NSN'] * 0.5, $precision, '.', '')),
            ];
        }
        return $result;
    }

    public function stepRanking(int $precision = 3)
    {
        $result = [];
        $score = $this->stepCalculateAssesmentScore($precision);

        usort($score, function ($a, $b) {
            return $b['AS'] <=> $a['AS'];
        });
        foreach ($score as $key => $value) {
            $value['Alternatif'] = parent::getAlternatifNama(parent::removeAlias($value['Alternatif']));
            $value['Ranking'] = $key + 1;
            $result[] = $value;
        }
        return $result;
    }
}
