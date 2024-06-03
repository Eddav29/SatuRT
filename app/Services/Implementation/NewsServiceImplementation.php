<?php

namespace App\Services\Implementation;

use App\Models\Informasi;
use App\Services\Interfaces\RepositoryService;
use App\Services\NewsService;
use App\Services\Notification\NotificationPusher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsServiceImplementation implements RepositoryService, NewsService
{
    public function create(Request $request): Model
    {
        // TODO: Implement create() method.
        return new Informasi();
    }

    public function update(string $id, Request $request): Collection
    {
        // TODO: Implement update() method.
        return Collection::make();
    }

    public function delete(string $id): bool
    {
        // TODO: Implement delete() method.
        return true;
    }

    public function find(string $id): Model
    {
        try {
            $information = Informasi::findOrFail($id);
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            abort(500, $e->getMessage());
        }
        return $information;
    }

    public function all(): Collection
    {
        try {
            $informations = Informasi::all()
                ->where('deleted_at', 0)
                ->where('jenis_informasi', '!=', 'Pengumuman')
                ->sortByDesc('created_at');
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            abort(500, $e->getMessage());
        }

        return $informations;
    }

    public function getRandomNews(): Collection
    {
        try {
            $informations = Informasi::where('jenis_informasi', '!=', 'Pengumuman')
                ->inRandomOrder()
                ->take(4)
                ->get();
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            abort(500, $e->getMessage());
        }

        return $informations;
    }

    public function getNewsWithPagination(string|null $id, array $filters): LengthAwarePaginator|null
    {
        if (is_null($id)) {
            return null;
        }

        try {
            $informations = Informasi::whereNull('deleted_at')
                ->where('jenis_informasi', '!=', 'Pengumuman')
                ->whereNot('informasi_id', $id)
                ->orderBy('created_at', 'desc')
                ->filter($filters)
                ->paginate(10);
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            abort(500, $e->getMessage());
        }


        return $informations;
    }

    public function getLatestNews(): Model|null
    {
        try {
            $information = Informasi::where('jenis_informasi', '!=', 'Pengumuman')
                ->orWhere('jenis_informasi', '!=', 'Dokumentasi Rapat')
                ->orderBy('created_at', 'desc')
                ->first();
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            abort(500, $e->getMessage());
        }

        return $information;
    }

    public function filter(string $search = '', string $filter = 'Semua'): LengthAwarePaginator
    {
        try {
            $information = Informasi::whereNull('deleted_at')
                ->where('jenis_informasi', '!=', 'Pengumuman')
                ->where('jenis_informasi', $filter === 'Semua' ? '!=' : '=', $filter)
                ->where('judul_informasi', 'LIKE', '%' . $search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            abort(500, $e->getMessage());
        }

        return $information;
    }

    public function getAllTypes(): array
    {
        try {
            return Informasi::getListJenisInformasi();
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            abort(500, $e->getMessage());
        }
    }
}
