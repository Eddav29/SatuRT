<?php

namespace App\Services\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BusinessService
{
    public function getBusinessesWithPagination(array $filters): LengthAwarePaginator;
    public function getAllStatuses(): array;
    public function getAllTypes(): array;
}