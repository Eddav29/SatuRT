<?php

namespace Tests\Feature;

use App\Models\Pelaporan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResidentReportApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSuccess(): void
    {
        $this->get('/api/pelaporan/1', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => 1,
                    'jenis_laporan' => 'Pengaduan',
                    'attachment' => 'amet',
                    'accepted_at' => 'Minggu, 13 Oktober 1974',
                    'accepted_by' => 'Granville Buckridge',
                    'created_at' => 'Selasa, 09 April 2024',
                    'created_by' => 'Dr. Kathlyn Lynch DDS',
                    'purposes' => 'Et est quia reprehenderit tempore suscipit.',
                    'status' => 'Ditolak',
                    'description' => 'Ipsum commodi nam assumenda sequi culpa. Omnis qui vel ut asperiores dolores et. Omnis provident inventore earum beatae est rerum temporibus.',
                ]
            ]);
    }

    public function testNotFound(): void
    {
        $this->get('/api/pelaporan/89271491729274928374', [
            'Authorization' => 'test'
        ])->assertStatus(404);
    }
}
