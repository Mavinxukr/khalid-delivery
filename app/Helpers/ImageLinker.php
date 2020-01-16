<?php


namespace App\Helpers;


class ImageLinker
{
    public static function linker($uri)
    {
        if (!is_null($uri)){
           $string = explode(':',$uri);
           if ($string[0] === 'https' || $string[0] === 'http' ){
              return $uri;
           }else{
               return config('app.url_image').$uri;
           }
        }else{
            return null;
        }
    }
}
