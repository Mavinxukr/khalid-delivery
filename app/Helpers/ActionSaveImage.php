<?php


namespace App\Helpers;


use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActionSaveImage
{
    public static function updateImage($file, $model, string $entity) :string
    {
        if (!is_null($file)){
            $ext = explode("/", $file->getClientMimeType());
            $name = Str::random('60').'.'.end($ext);
            $path = "image/$entity/$name";
            if (file_exists(storage_path('app/public/').$model->image)){
                Storage::disk('public')->delete($model->image);
            }
            Storage::disk('public')->put($path,file_get_contents($file));
            return  $path;
        }else{
            return $model->image;
        }
    }
}
