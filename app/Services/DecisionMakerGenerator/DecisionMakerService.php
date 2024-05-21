<?php

namespace App\Services\DecisionMakerGenerator;

use App\Models\KriteriaAlternatif;
use App\Utils\TableGenerator\TableService;

class DecisionMakerService
{
    private $kriteria;
    private $bobot;
    private $tipe;

    private $alternatif;
    private $data;
    private $tableService;

    public function __construct(bool $nomalize = true)
    {
        $data = KriteriaAlternatif::with('kriteria', 'alternatif')
            ->orderBy('alternatif_id')
            ->orderBy('kriteria_id')
            ->get();
        // Mengumpulkan kriteria dan alternatif dalam bentuk array
        $this->kriteria = $data->pluck('kriteria.nama_kriteria', 'kriteria_id')->unique()->values()->all();
        $this->alternatif = $data->pluck('alternatif.nama_alternatif', 'alternatif_id')->unique()->values()->all();
        $this->bobot = $data->pluck('kriteria.bobot', 'kriteria_id')->values()->all();
        $this->tipe = $data->pluck('kriteria.jenis_kriteria', 'kriteria_id')->values()->all();

        // Inisialisasi array data
        $this->data = [];

        // Loop melalui data untuk mengisi matriks
        $alternatifIds = array_keys($data->groupBy('alternatif_id')->toArray());
        $kriteriaIds = array_keys($data->groupBy('kriteria_id')->toArray());

        for ($i = 0; $i < count($alternatifIds); $i++) {
            for ($j = 0; $j < count($kriteriaIds); $j++) {
                $alternatifId = $alternatifIds[$i];
                $kriteriaId = $kriteriaIds[$j];
                // Cari item yang sesuai dengan alternatifId dan kriteriaId
                $item = $data->where('alternatif_id', $alternatifId)->where('kriteria_id', $kriteriaId)->first();
                if ($item) {
                    $this->data[$i][$j] = $this->trimTrailingZeros($item['nilai']);
                }
            }
        }
        if ($nomalize) {
            $this->_normalizedBobot();
        }
        $this->tableService = new TableService($this->kriteria, $this->bobot, $this->tipe, $this->alternatif);
    }

    private function _normalizedBobot()
    {
        $totaldBobot = array_sum($this->bobot);
        foreach ($this->bobot as $key => $value) {
            $this->bobot[$key] = $this->trimTrailingZeros(number_format($value / $totaldBobot, 3, '.', ''));
        }
    }

    public function getKriteria()
    {
        return $this->kriteria;
    }

    public function getBobot()
    {
        return $this->bobot;
    }

    public function getTipe()
    {
        return $this->tipe;
    }

    public function getAlternatifs()
    {
        return $this->alternatif;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getKriteriaNama(int $id)
    {
        return $this->kriteria[$id];
    }

    public function getAlternatifNama(int $id)
    {
        return $this->alternatif[$id];
    }

    public function getBobotValue(int $id)
    {
        return $this->bobot[$id];
    }

    public function getTipeValue(int $id)
    {
        return $this->tipe[$id];
    }

    public function getAlternatifValue(int $kriteriaId, int $alternativeId)
    {
        return collect($this->data)->where('kriteria_id', $kriteriaId)->where('alternatif_id', $alternativeId)->first()['nilai'];
    }

    public function getKriteriaIndex(string $name)
    {
        return array_search($name, $this->kriteria);
    }

    public function getAlternatifIndex(string $name)
    {
        return array_search($name, $this->alternatif);
    }

    public function getBobotIndex(string $name)
    {
        return array_search($name, $this->bobot);
    }

    public function getTipeIndex(string $name)
    {
        return array_search($name, $this->tipe);
    }

    public function getKriteriaCount()
    {
        return count($this->kriteria);
    }

    public function getAlternatifCount()
    {
        return count($this->alternatif);
    }

    public function getBobotCount()
    {
        return count($this->bobot);
    }

    public function getTipeCount()
    {
        return count($this->tipe);
    }

    public function createTableService(): TableService
    {
        return $this->tableService;
    }

    public function getKriteriaTable(): string
    {
        foreach ($this->kriteria as $key => $value) {
            $data[] = [
                'Kriteria' => $value,
                'Alias' => 'K' . $key,
                'Bobot' => $this->bobot[$key]
            ];
        }

        return $this->tableService->createTable($data);
    }

    public function getAlternatifTable(): string
    {
        foreach ($this->alternatif as $key => $value) {
            $data[] = [
                'Alternatif' => $value,
                'Alias' => 'A' . $key
            ];
        }
        return $this->tableService->createTable($data);
    }

    public function getScoreMatrixData(): string
    {
        return $this->tableService->createTable($this->data);
    }

    protected function trimTrailingZeros(string $value): string
    {
        return rtrim(preg_replace('/(\.[0-9]*?)0*$/', '$1', $value), '.');
    }

    protected function removeAlias(string $value): string
    {
        return preg_replace('/[^0-9]/', '', $value);
    }
}
