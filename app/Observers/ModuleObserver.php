<?php

namespace App\Observers;

use App\Models\Module;
use App\Services\Helper;

class ModuleObserver
{
    public function creating(Module $module)
    {
        // Create a unique slug for the model
        $slug = $module->slug ?? $module->title;
        $module->slug = Helper::slugify($slug, Module::class);

    }
}
