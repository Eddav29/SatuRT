<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface NewsService
{
    public function getRandomNews(): Collection;

    public function getNewsWithPagination(string|null $id, array $filters): LengthAwarePaginator|null;

    public function getLatestNews(): Model|null;

    public function getAllTypes(): array;

}
