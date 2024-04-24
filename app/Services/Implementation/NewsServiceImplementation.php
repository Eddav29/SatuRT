<?php

namespace App\Services\Implementation;

use App\Models\Informasi;
use App\Services\CRUDService;
use App\Services\NewsService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsServiceImplementation implements CRUDService, NewsService
{
    public function create(Request $request): Collection
    {
        // TODO: Implement create() method.
        return Collection::make();
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
        $information = Informasi::find($id);
        return $information;
    }

    public function all(): Collection
    {
        $informations = Informasi::all()
            ->where('deleted_at', 0)
            ->where('jenis_informasi', '!=', 'Pengumuman')
            ->sortByDesc('created_at');

        return $informations;
    }

    public function getRandomNews(): Collection
    {
        $informations = Informasi::whereNull('deleted_at')
            ->where('jenis_informasi', '!=', 'Pengumuman')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return $informations;
    }

    public function getNewsWithPagination(string|null $id, array $filters): LengthAwarePaginator|null
    {
        if (is_null($id)) {
            return null;
        }

        $informations = Informasi::whereNull('deleted_at')
            ->where('jenis_informasi', '!=', 'Pengumuman')
            ->whereNot('informasi_id', $id)
            ->orderBy('created_at', 'desc')
            ->filter($filters)
            ->paginate(10);

        return $informations;
    }

    public function getLatestNews(): Model|null
    {
        $information = Informasi::whereNull('deleted_at')
            ->where('jenis_informasi', '!=', 'Pengumuman')
            ->orderBy('created_at', 'desc')
            ->first();

        return $information;
    }

    public function filter(string $search = '', string $filter = 'Semua'): LengthAwarePaginator
    {

        $information = Informasi::whereNull('deleted_at')
            ->where('jenis_informasi', '!=', 'Pengumuman')
            ->where('jenis_informasi', $filter === 'Semua' ? '!=' : '=', $filter)
            ->where('judul_informasi', 'LIKE', '%' . $search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $information;
    }

    public function getAllTypes(): array
    {
        return Informasi::getListJenisInformasi();
    }
}