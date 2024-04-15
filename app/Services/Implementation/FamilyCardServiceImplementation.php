<?php

namespace App\Services\Implementation;

use App\Models\KartuKeluarga;
use App\Services\CRUDService;
use App\Services\FamilyCardService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use PHPUnit\TestRunner\TestResult\Collector;

class FamilyCardServiceImplementation implements FamilyCardService, CRUDService
{
    public function getFamilyCardList(): Collection
    {
        return KartuKeluarga::with(['penduduk' => function ($query) {
            $query->where('status_hubungan_dalam_keluarga', 'Kepala Keluarga');
        }])->withCount('penduduk')->get();
    }

    public function find(string $id): KartuKeluarga
    {
        return KartuKeluarga::findOrFail($id);
    }

    public function all(): Collection
    {
        return KartuKeluarga::all();
    }

    public function create(Request $request): Collection
    {
        return KartuKeluarga::create($request);
    }

    public function update(string $id, Request $request): Collection
    {
        $familyCard = KartuKeluarga::findOrFail($id);
        $familyCard->update($request);
        return $familyCard;
    }

    public function delete(string $id): bool
    {
        return KartuKeluarga::destroy($id);
    }

}
