<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface FamilyCardService
{
    public function getFamilyCardList(): Collection;
}
