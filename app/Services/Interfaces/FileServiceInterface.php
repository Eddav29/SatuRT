<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface FileServiceInterface
{
    public static function uploadFile(string $disk, Request $request, string $name = 'images') : string;
    public static function deleteFile(string $disk, string $path) : bool;
}
