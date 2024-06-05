<?php

namespace Tests\Feature;

use App\Models\Informasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnnouncementApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetSuccess()
    {
        $announcement = Informasi::with(['penduduk'])->where('jenis_informasi', 'Pengumuman')->first();


        $this->get('/api/pengumuman/' . $announcement->informasi_id, [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => '0f3e122c-7375-4661-82b8-c64f5bc4dc57',
                    'title' => 'consequatur',
                    'created_by' => 'Bethel Spinka DDS',
                    'created_at' => 'Selasa, 09 April 2024',
                    'description' => 'laudantium',
                ]
            ]);
    }

    public function testGetNotFound()
    {
        $this->get('/api/pengumuman/0', [
            'Authorization' => 'test'
        ])->assertStatus(404);
    }
}
