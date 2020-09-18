<?php
namespace App\Services;
use Illuminate\Support\Str;

class Helper
{

    public static function slugify($name, $parentClass)
    {
        $slug = Str::slug($name);

        while($parentClass::withTrashed()->whereSlug($slug)->first()){
            $slug = Str::slug($slug.'-'.rand(1,5));
        }

        return $slug;
    }
    
        
}