<?php

namespace App\Observers;

use App\Models\Type;
use App\Services\Helper;

class TypeObserver
{
    public function creating(Type $type)
    {
        // Create a unique slug for the model
        $slug = $type->slug ?? $type->name;
        $type->slug = Helper::slugify($slug, Type::class);
        
    }

    public function updating(Type $type)
    {
        $type->slug = \Str::slug($type->slug);
        
        // Don't generate new slug when the slug is same as old.
        if($type->slug != $type->getOriginal('slug'))
        {
           $type->slug = Helper::slugify($type->slug, Type::class);
        } 
    }
}
