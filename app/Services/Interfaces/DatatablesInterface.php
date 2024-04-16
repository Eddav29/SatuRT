<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface DatatablesInterface
{
    public static function getDatatable($id = null): Collection;
}
