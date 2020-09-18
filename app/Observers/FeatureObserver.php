<?php

namespace App\Observers;

use App\Models\Feature;
use App\Services\Helper;

class FeatureObserver
{
    public function creating(Feature $feature)
    {
        // Create a unique slug for the model
        $slug = $feature->slug ?? $feature->name;
        $feature->slug = Helper::slugify($slug, Feature::class);
        
    }

    public function updating(Feature $feature)
    {
        $feature->slug = \Str::slug($feature->slug);
        
        // Don't generate new slug when the slug is same as old.
        if($feature->slug != $feature->getOriginal('slug'))
        {
           $feature->slug = Helper::slugify($feature->slug, Feature::class);
        } 
    }
}
