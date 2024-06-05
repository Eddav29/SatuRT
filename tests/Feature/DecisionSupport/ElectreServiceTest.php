<?php

namespace Tests\Feature\DecisionSupport;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\KriteriaAlternatif;
use App\Services\DecisionMakerGenerator\Support\ElectreService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ElectreServiceTest extends TestCase
{
    use RefreshDatabase;

    private $electreService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seedDatabase();

        $this->electreService = new ElectreService(false);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    private function seedDatabase(): void
    {
        $kriteria = [
            [
                'kriteria_id' => 1,
                'nama_kriteria' => 'jarak dengan pasar terdekat (km)',
                'bobot' => 5,
                'jenis_kriteria' => 'Benefit',
            ],
            [
                'kriteria_id' => 2,
                'nama_kriteria' => 'kepadatan penduduk di sekitar lokasi
                (orang/km2)',
                'bobot' => 3,
                'jenis_kriteria' => 'Benefit',
            ],
            [
                'kriteria_id' => 3,
                'nama_kriteria' => 'Jarak dari pabrik (km)',
                'bobot' => 4,
                'jenis_kriteria' => 'Benefit',
            ],
            [
                'kriteria_id' => 4,
                'nama_kriteria' => 'Jarak dengan gudang yang sudah ada (km',
                'bobot' => 4,
                'jenis_kriteria' => 'Cost',
            ],
            [
                'kriteria_id' => 5,
                'nama_kriteria' => 'harga tanah untuk lokasi (x1000 Rp/m2)',
                'bobot' => 2,
                'jenis_kriteria' => 'Cost',
            ],
        ];
        foreach ($kriteria as $kriteria) {
            Kriteria::factory()
                ->count(1)
                ->create($kriteria);
        }

        $alternatif = [
            [
                'alternatif_id' => 1,
                'nama_alternatif' => 'Ngemplak'
            ],
            [
                'alternatif_id' => 2,
                'nama_alternatif' => 'Kalasan'
            ],
            [
                'alternatif_id' => 3,
                'nama_alternatif' => 'Kota Gedhe'
            ],
        ];
        foreach ($alternatif as $alternatif) {
            Alternatif::factory()
                ->count(1)
                ->create($alternatif);
        }
        $tableData = [
            [0.75, 2000, 18, 50, 500],
            [0.5, 1500, 20, 40, 450],
            [0.9, 2050, 35, 35, 800],
        ];
        foreach (Kriteria::all() as $kriteria) {
            foreach (Alternatif::all() as $alternatif) {
                KriteriaAlternatif::factory()
                    ->count(1)
                    ->create([
                        'kriteria_id' => $kriteria->kriteria_id,
                        'alternatif_id' => $alternatif->alternatif_id,
                        'nilai' => $tableData[$alternatif->alternatif_id - 1][$kriteria->kriteria_id - 1],
                    ]);
            }
        }
    }

    public function test_get_data(): void
    {
        $this->assertTrue(true);
        $this->assertIsArray($this->electreService->getStepData());
        $this->assertArrayHasKey('decisionMatrix', $this->electreService->getStepData());
        $this->assertArrayHasKey('normalizationR', $this->electreService->getStepData());
        $this->assertArrayHasKey('weightedNormalizationR', $this->electreService->getStepData());
        $this->assertArrayHasKey('helperConcordanceMatrix', $this->electreService->getStepData());
        $this->assertArrayHasKey('helperDiscordanceMatrix', $this->electreService->getStepData());
        $this->assertEquals(3, count($this->electreService->getStepData()['decisionMatrix']));
        $this->assertEquals(5, count($this->electreService->getStepData()['decisionMatrix'][1]));
        $this->assertEquals(20, $this->electreService->getStepData()['decisionMatrix'][1][2]);
    }

    public function test_normalization_r(): void
    {
        $this->assertIsArray($this->electreService->getStepData()['normalizationR']);
        $this->assertEquals(3, count($this->electreService->getStepData()['normalizationR']));
        $this->assertEquals(5, count($this->electreService->getStepData()['normalizationR'][0]));
        $this->assertEquals(0.453, $this->electreService->getStepData()['normalizationR'][1][2]);
    }

    public function test_weighted_normalization_r(): void
    {
        $this->assertIsArray($this->electreService->getStepData()['weightedNormalizationR']);
        $this->assertEquals(3, count($this->electreService->getStepData()['weightedNormalizationR']));
        $this->assertEquals(5, count($this->electreService->getStepData()['weightedNormalizationR'][0]));
        $this->assertEquals(2.740, $this->electreService->getStepData()['weightedNormalizationR'][0][3]);
    }

    public function test_helper_concordance_matrix(): void
    {
        $this->assertIsArray($this->electreService->getStepData()['helperConcordanceMatrix']);
        $this->assertEquals(6, count($this->electreService->getStepData()['helperConcordanceMatrix']));
        $this->assertEquals(5, count($this->electreService->getStepData()['helperConcordanceMatrix']['C12']));
        $this->assertEquals([1,1,0,1,1], $this->electreService->getStepData()['helperConcordanceMatrix']['C12']);
        $this->assertEquals([0,0,0,1,0], $this->electreService->getStepData()['helperConcordanceMatrix']['C13']);
        $this->assertEquals([0,0,1,0,0], $this->electreService->getStepData()['helperConcordanceMatrix']['C21']);
        $this->assertEquals([0,0,0,1,0], $this->electreService->getStepData()['helperConcordanceMatrix']['C23']);
        $this->assertEquals([1,1,1,0,1], $this->electreService->getStepData()['helperConcordanceMatrix']['C31']);
        $this->assertEquals([1,1,1,0,1], $this->electreService->getStepData()['helperConcordanceMatrix']['C32']);
    }

    public function test_helper_discordance_matrix(): void
    {
        $this->assertIsArray($this->electreService->getStepData()['helperDiscordanceMatrix']);
        $this->assertEquals(6, count($this->electreService->getStepData()['helperDiscordanceMatrix']));
        $this->assertEquals(5, count($this->electreService->getStepData()['helperDiscordanceMatrix']['D12']));
        $this->assertEquals([0,0,1,0,0], $this->electreService->getStepData()['helperDiscordanceMatrix']['D12']);
        $this->assertEquals([1,1,1,0,1], $this->electreService->getStepData()['helperDiscordanceMatrix']['D13']);
        $this->assertEquals([1,1,0,1,1], $this->electreService->getStepData()['helperDiscordanceMatrix']['D21']);
        $this->assertEquals([1,1,1,0,1], $this->electreService->getStepData()['helperDiscordanceMatrix']['D23']);
        $this->assertEquals([0,0,0,1,0], $this->electreService->getStepData()['helperDiscordanceMatrix']['D31']);
        $this->assertEquals([0,0,0,1,0], $this->electreService->getStepData()['helperDiscordanceMatrix']['D32']);
    }

    public function test_get_index_criteria(): void
    {
        $this->assertIsArray($this->electreService->getStepData()['indexCriteria']);
        $this->assertEquals(2, count($this->electreService->getStepData()['indexCriteria']));
        $this->assertArrayHasKey('Concordance', $this->electreService->getStepData()['indexCriteria']);
        $this->assertArrayHasKey('Discordance', $this->electreService->getStepData()['indexCriteria']);

    }


    public function test_calculate_matrix_concordance(): void
    {
        $this->assertIsArray($this->electreService->getStepData()['matrixConcordance']['C']);
        $this->assertEquals(3, count($this->electreService->getStepData()['matrixConcordance']['C']));
        $this->assertEquals(3, count($this->electreService->getStepData()['matrixConcordance']['C'][0]));
        $this->assertEquals(['-', 14, 4], $this->electreService->getStepData()['matrixConcordance']['C'][0]);
        $this->assertEquals([4, '-', 4], $this->electreService->getStepData()['matrixConcordance']['C'][1]);
        $this->assertEquals([14, 14, '-'], $this->electreService->getStepData()['matrixConcordance']['C'][2]);
    }

    public function test_calculate_matrix_discordance(): void
    {
        $this->assertIsArray($this->electreService->getStepData()['matrixDiscordance']['D']);
        $this->assertEquals(3, count($this->electreService->getStepData()['matrixDiscordance']['D']));
        $this->assertEquals(3, count($this->electreService->getStepData()['matrixDiscordance']['D'][0]));

        $this->assertEquals(['-', 0.184, 1], $this->electreService->getStepData()['matrixDiscordance']['D'][0]);
        $this->assertEquals([1, '-', 1], $this->electreService->getStepData()['matrixDiscordance']['D'][1]);
        $this->assertEquals([0.532, 0.173, '-'], $this->electreService->getStepData()['matrixDiscordance']['D'][2]);
    }

    public function test_calculate_threshold_matrix_concordance() {
        $this->assertIsNotArray($this->electreService->getStepData()['thresholdMatrixConcordance'][0][0]);
        $this->assertEquals(9, $this->electreService->getStepData()['thresholdMatrixConcordance'][0][0]);
    }

    public function test_calculate_threshold_matrix_discordance() {
        $this->assertIsNotArray($this->electreService->getStepData()['thresholdMatrixDiscordance'][0][0]);
        $this->assertEquals(0.648, $this->electreService->getStepData()['thresholdMatrixDiscordance'][0][0]);
    }

    public function test_calculate_matrix_dominant_concordance() {
        $this->assertIsArray($this->electreService->getStepData()['matrixDominantConcordance']['F']);
        $this->assertEquals(3, count($this->electreService->getStepData()['matrixDominantConcordance']['F']));
        $this->assertEquals(3, count($this->electreService->getStepData()['matrixDominantConcordance']['F'][1]));
        $this->assertEquals(['-', 1, 0], $this->electreService->getStepData()['matrixDominantConcordance']['F'][0]);
        $this->assertEquals([0, '-', 0], $this->electreService->getStepData()['matrixDominantConcordance']['F'][1]);
        $this->assertEquals([1, 1, '-'], $this->electreService->getStepData()['matrixDominantConcordance']['F'][2]);
    }

    public function test_calculate_matrix_dominant_discordance() {
        $this->assertIsArray($this->electreService->getStepData()['matrixDominantDiscordance']['G']);
        $this->assertEquals(3, count($this->electreService->getStepData()['matrixDominantDiscordance']['G']));
        $this->assertEquals(3, count($this->electreService->getStepData()['matrixDominantDiscordance']['G'][1]));
        $this->assertEquals(['-', 0, 1], $this->electreService->getStepData()['matrixDominantDiscordance']['G'][0]);
        $this->assertEquals([1, '-', 1], $this->electreService->getStepData()['matrixDominantDiscordance']['G'][1]);
        $this->assertEquals([0, 0, '-'], $this->electreService->getStepData()['matrixDominantDiscordance']['G'][2]);
    }

    public function test_determine_aggregate_matrix() {
        $this->assertIsArray($this->electreService->getStepData()['aggregateMatrix']);
        $this->assertEquals(3, count($this->electreService->getStepData()['aggregateMatrix']['E']));
        $this->assertEquals(3, count($this->electreService->getStepData()['aggregateMatrix']['E'][0]));

        $this->assertEquals(['-', 0, 0], $this->electreService->getStepData()['aggregateMatrix']['E'][0]);
        $this->assertEquals([0, '-', 0], $this->electreService->getStepData()['aggregateMatrix']['E'][1]);
        $this->assertEquals([0, 0, '-'], $this->electreService->getStepData()['aggregateMatrix']['E'][2]);
    }

    public function test_ranking() {
        $this->assertIsArray($this->electreService->getStepData()['ranking']);
        $this->assertEquals(3, count($this->electreService->getStepData()['ranking']));

        $this->assertEquals([
            'Alternatif' => 'Kota Gedhe',
            'E' => 27.295,
            'Ranking' => 1,
        ], $this->electreService->getStepData()['ranking'][0]);

        $this->assertEquals([
            'Alternatif' => 'Ngemplak',
            'E' => 16.816,
            'Ranking' => 2,
        ], $this->electreService->getStepData()['ranking'][1]);

        $this->assertEquals([
            'Alternatif' => 'Kalasan',
            'E' => 6,
            'Ranking' => 3,
        ], $this->electreService->getStepData()['ranking'][2]);

    }
}
