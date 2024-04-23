<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface ImageServiceInterface
{
    public static function uploadImage($disk, Request $request);
    public static function deleteImage($disk, $path) : bool;
}
