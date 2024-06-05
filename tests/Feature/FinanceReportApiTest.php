<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FinanceReportApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSuccess(): void
    {
        $this->get('/api/laporan-keuangan/1', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => 1,
                    'title' => 'Et id beatae architecto repudiandae odio ullam.',
                    'finance_type' => "Pengeluaran",
                    'financial_origin' => "Kas Umum",
                    'amount' => 956459,
                    'description' => "Perspiciatis molestiae facere tempore deserunt voluptatibus harum possimus est.",
                    'created_at' => "Selasa, 09 April 2024",
                    'updated_at' => "Selasa, 09 April 2024",
                    'balance_before' => 903933,
                    'balance_now' => -52526
                ]
            ]);
    }

    public function testNotFound(): void
    {
        $this->get('/api/laporan-keuangan/89271491729274928374', [
            'Authorization' => 'test'
        ])->assertStatus(404);
    }
}
