<?php

namespace Tests\Feature;

use App\Services\DecisionMakerGenerator\DecisionMakerService;
use App\Services\DecisionMakerGenerator\Support\MabacService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MabacServiceTest extends TestCase
{
    public function test_get_data()
    {
        $decisionMaker = new DecisionMakerService();
        $data = $decisionMaker->getData();

        $this->assertIsArray($data);
    }

    public function test_get_step()
    {
        $mabac = new MabacService();

        dump($mabac->getData()['rankingMatrix']);

        $this->assertIsArray($mabac->getData()['rankingMatrix']);
    }

    public function test_normalized_matrix()
    {
        $mabac = new MabacService();

        $mabac->normalizeMatrix();

        $this->assertIsArray($mabac->getData()['normalized']);
    }

    public function test_transpose_matrix()
    {
        $decisionMaker = new DecisionMakerService();
        $mabac = new MabacService();

        $this->assertIsArray($mabac->transposeMatrix($decisionMaker->getData()));
    }

    public function test_get_max()
    {
        $decisionMaker = new DecisionMakerService();
        $mabac = new MabacService();

        $matrix = $mabac->transposeMatrix($decisionMaker->getData());

        $max = $mabac->getMax($matrix);

        $this->assertIsArray($max);
    }

    public function test_get_min()
    {
        $decisionMaker = new DecisionMakerService();
        $mabac = new MabacService();

        $matrix = $mabac->transposeMatrix($decisionMaker->getData());

        $min = $mabac->getMin($matrix);

        $this->assertIsArray($min);
    }

    public function test_get_kriteria()
    {
        $decisionMaker = new DecisionMakerService();

        $this->assertIsArray($decisionMaker->getKriteria());
    }

    public function test_get_criteria_type()
    {
        $decisionMaker = new DecisionMakerService();

        $this->assertIsArray($decisionMaker->getTipe());
    }

    public function test_get_bobot()
    {
        $decisionMaker = new DecisionMakerService();

        $this->assertIsArray($decisionMaker->getBobot());
    }

    public function test_weighted_matrix()
    {
        $mabac = new MabacService();
        $mabac->weightedMatrix();

        $this->assertIsArray($mabac->getData()['weightedMatrix']);
    }

    public function test_bordered_forecast_matrix()
    {
        $mabac = new MabacService();
        $mabac->borderForecastAreaMatrix();

        $this->assertIsArray($mabac->getData()['borderForecastAreaMatrix']);
    }

    public function test_altered_forecast_matrix()
    {
        $mabac = new MabacService();

        $mabac->alternativeDistanceMatrix();

        $this->assertIsArray($mabac->getData()['alternativeDistanceMatrix']);
    }

    public function test_ranking_matrix()
    {
        $mabac = new MabacService();

        $mabac->rankingMatrix();

        $this->assertIsArray($mabac->getData()['rankingMatrix']);
    }
}
