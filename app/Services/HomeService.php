<?php

namespace App\Services;

use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Collection;

interface HomeService
{
    public function getThreeLastUMKM(): Collection;

    public function getFourLastInformation(): Collection;

    public function getLeader(): Penduduk;
}
