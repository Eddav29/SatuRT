<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface HomeService
{
    public function getThreeLastUMKM(): Collection;

    public function getFourLastInformation(): Collection;
}
