<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface NewsService
{
    public function getRandomNews(): Collection;

    public function getNewsWithPagination(string $id, array $filters): LengthAwarePaginator;

    public function getLatestNews(): Model;

    public function getAllTypes(): array;

}