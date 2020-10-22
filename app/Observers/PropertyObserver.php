<?php

namespace App\Observers;

use App\Models\Property;
use App\Services\Helper;

class PropertyObserver
{
    public function creating(Property $property)
    {
        // Create a unique slug for the model
        $slug = $property->slug ?? $property->name;
        $property->slug = Helper::slugify($slug, Property::class);

        dd("escaped");
        dd($property);
        
    }

    public function updating(Property $property)
    {
        $property->slug = \Str::slug($property->slug);
        
        // Don't generate new slug when the slug is same as old.
        if($property->slug != $property->getOriginal('slug'))
        {
           $property->slug = Helper::slugify($property->slug, Property::class);
        } 
    }
}
