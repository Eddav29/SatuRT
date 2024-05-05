<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface RecordServiceInterface
{
    public static function find(string $id): Model;

    public static function all(): Collection;

    public static function create(Request $request): Collection | Model;

    public static function update(string $id, Request $request): Collection | Model;

    public static function delete(string $id): bool;
}
