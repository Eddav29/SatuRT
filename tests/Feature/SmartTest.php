<?php

namespace Tests\Feature;

use App\Services\DecisionMakerGenerator\Support\SmartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SmartTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $smart = new SmartService();

        $smart->getScore();
    }
}
