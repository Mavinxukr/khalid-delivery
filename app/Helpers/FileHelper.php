<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class FileHelper
{
    public static function store($file, $path) : string
    {

        $name = Str::slug($file->getClientOriginalName(),'-');
        $ext = $file->getClientOriginalExtension();
        $path .=$name.'.'.$ext;
        return Storage::disk('public')->put($path, $file);

    }

    public static function remove($path_toDelete)
    {
        $path = str_replace(config('app.url') . '/storage/', '', $path_toDelete);
        Storage::disk('public')->delete($path);
    }
}
