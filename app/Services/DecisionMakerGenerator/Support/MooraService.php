<?php

namespace App\Services\DecisionMakerGenerator\Support;

use App\Services\DecisionMakerGenerator\DecisionMakerService;

class MooraService extends DecisionMakerService{

    private array $stepData = [];

    public function __construct(bool $normalize = true){
        parent::__construct($normalize);
        $this->stepData['decisionMatrix'] = parent::getData();
        $this->calculate();
    }

    public function getStepData(): array
    {
        return $this->stepData;
    }


    public function calculate(){
        try{
            $this->stepNormalization();
            $this->optimizeValueAttribute();
            $this->stepMaxandMin();
            $this->stepRanking();
        }catch(\Throwable){
            return response()->json(['error' => 'error calculate data.'], 404);
        }


    }

    private function stepNormalization(){
        try{
            $matrix = $this->stepData['decisionMatrix'];
            $rowCount = count($matrix);
            $colCount = count($matrix[1]);
    
            $sumOfSquares = array_fill(0, $colCount, 0);
            for ($j = 0; $j < $colCount; $j++) {
                for ($i = 0; $i < $rowCount; $i++) {
                    $sumOfSquares[$j] += pow($matrix[$i][$j], 2);
    
                }
                $sumOfSquares[$j] =
                $this->trimTrailingZeros(number_format(sqrt($sumOfSquares[$j]), 3, '.', ''));
            }
    
            for ($i = 0; $i < $rowCount; $i++) {
                $normalizedMatrix = [];
                for ($j = 0; $j < $colCount; $j++) {
                    $value = $this->trimTrailingZeros(number_format(($matrix[$i][$j] / $sumOfSquares[$j]),3,'.',''));
                    $normalizedMatrix[] = $value;
                }
                $n[] = $normalizedMatrix;
            }
    
            $this->stepData['normalizedMatrix'] = $n;
    
        }catch(\Throwable){
            return response()->json(['error' => 'error to normalize data.'], 404);
        }

    }

    private function optimizeValueAttribute(){
        try{
            $weight = parent::getBobot();
            $normalizedMatrix = $this->stepData['normalizedMatrix'];
            $value = [];
    
            for ($i = 0; $i < count($normalizedMatrix); $i++) {
                $row = [];
                for ($j = 0; $j < count($normalizedMatrix[$i]); $j++) {
                    $row[] = $this->trimTrailingZeros(number_format((($weight[$j]) * $normalizedMatrix[$i][$j]), 3, '.', ''));
                }
                $value[] = $row;
            }
    
            $this->stepData['weightedMatrix'] = $value;
    
        }catch(\Throwable){
            return response()->json(['error' => 'error to optimize data.'], 404);
        }

    }

    private function stepMaxandMin(){
        try{
            $matrix = $this->stepData['weightedMatrix'];
            $type = parent::getTipe();
            $result = [];
            $alternatif = parent::getAlternatifs();
            for ($i = 0; $i < count($matrix); $i++) {
                $row = [];
                $benefit = 0;
                $cost = 0;
    
                for ($j = 0; $j < count($matrix[$i]); $j++) {
                    if ($type[$j] === 'Benefit') {
                        $benefit += $matrix[$i][$j];
                    } else {
                        $cost += ($matrix[$i][$j]);
                    }
                }
    
                $row = [
                    'Alternatif' => $alternatif[$i],
                    'Nilai Benefit' => $benefit,
                    'Nilai Cost' => $cost,
                    'Yi(Benefit-Cost)' => $this->trimTrailingZeros(number_format(($benefit - $cost), 3, '.', ''))
    
                ];
    
                $result[] = $row;
            }
    
            $this->stepData['nilaiY(i)'] = $result;
        }catch(\Throwable){
            return response()->json(['error' => 'error to find value max and min.'], 404);
        }


    }

    private function stepRanking(): void {
        try{
            $result = [];
            $yi = $this->stepData['nilaiY(i)'];
    
            usort($yi, function ($a, $b) {
                return $b['Yi(Benefit-Cost)'] <=> $a['Yi(Benefit-Cost)'];
            });
    
            foreach ($yi as $key => $value) {
                $result[] = [
                    'Alternatif' => $value['Alternatif'],
                    'Yi(Benefit-Cost)' => $value['Yi(Benefit-Cost)'],
                    'Ranking' => $value['Ranking'] = $key + 1,
                ];
            }
    
            $this->stepData['ranking'] = $result;
        }catch(\Throwable){
            abort(404);
        }
    }


}
