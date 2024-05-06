<?php

namespace App\Services\Implementation;

use App\Models\UMKM;
use App\Services\BusinessService;
use App\Services\Interfaces\RepositoryService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BusinessServiceImplementation implements RepositoryService, BusinessService
{
    public function create(Request $request): Model
    {
        // TODO: Implement create() method.
        return new UMKM();
    }

    public function update(string $id, Request $request): Collection
    {
        // TODO: Implement update() method.
        return new Collection();
    }

    public function delete(string $id): bool
    {
        // TODO: Implement delete() method.
        return true;
    }

    public function find(string $id): Model
    {
        $business = UMKM::with('penduduk')->find($id);
        return $business;
    }

    public function all(): Collection
    {
        $businesses = UMKM::all();
        return $businesses;
    }

    public function getBusinessesWithPagination(array $filters): LengthAwarePaginator
    {
        $businesses = UMKM::filter($filters)->paginate(10);
        return $businesses;
    }

    public function getAllStatuses(): array
    {
        return UMKM::getListStatusUMKM();
    }

    public function getAllTypes(): array
    {
        return UMKM::getListJenisUMKM();
    }
}
