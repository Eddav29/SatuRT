<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface FileServiceInterface
{
    public static function uploadFile($disk, Request $request);
    public static function deleteFile($disk, $path) : bool;
}
