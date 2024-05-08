<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface RepositoryService
{
    public function find(string $id): Model;

    public function all(): Collection;

    public function create(Request $request): Model;

    public function update(string $id, Request $request): Collection;

    public function delete(string $id): bool;
}