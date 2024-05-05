<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface HomeService
{
    public function getThreeLastUMKM(): Collection;

    public function getFourLastInformation(): Collection;
}
