<?php

namespace Tests\Feature;

use App\Services\DecisionMakerGenerator\Support\EddasService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EdasServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $edas = new EddasService();

        $edas->stepRanking();
    }
}
