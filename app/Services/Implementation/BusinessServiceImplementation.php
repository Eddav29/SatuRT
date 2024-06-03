<?php

namespace App\Services\Implementation;

use App\Models\UMKM;
use App\Services\BusinessService;
use App\Services\Interfaces\RepositoryService;
use App\Services\Notification\NotificationPusher;
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
        try {
            $business = UMKM::findOrFail($id);
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            abort(500, $e->getMessage());
        }
        return $business;
    }

    public function all(): Collection
    {
        try {
            $businesses = UMKM::all();
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            abort(500, $e->getMessage());
        }
        return $businesses;
    }

    public function getBusinessesWithPagination(array $filters): LengthAwarePaginator
    {
        try {
            $businesses = UMKM::filter($filters)->paginate(10);
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            abort(500, $e->getMessage());
        }
        return $businesses;
    }

    public function getAllStatuses(): array
    {
        try {
            return UMKM::getListStatusUMKM();
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            abort(500, $e->getMessage());
        }   
    }

    public function getAllTypes(): array
    {
        try {
            return UMKM::getListJenisUMKM();
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            abort(500, $e->getMessage());
        }
    }
}
