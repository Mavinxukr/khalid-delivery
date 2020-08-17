<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function store($file, $path) : string
    {
        Storage::put('public/' . $path, $file);
        return asset('storage/' . $path);
    }

    public static function remove($path_toDelete)
    {
        $path = str_replace(config('app.url') . '/storage/', '', $path_toDelete);
        Storage::disk('public')->delete($path);
    }
}
