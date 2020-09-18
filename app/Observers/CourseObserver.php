<?php

namespace App\Observers;

use App\Models\Course;
use App\Models\Module;
use App\Services\Helper;

class CourseObserver
{
    public function creating(Course $course)
    {
        // Create a unique slug for the model
        $slug = $course->slug ?? $course->title;
        $course->slug = Helper::slugify($slug, Course::class);

        
    }
    
    public function created(Course $course)
    {
        // Create default introduction module
        $course->modules()->create([
            'title' => '01. Introduction',
            'slug' => \Str::slug('01. Introduction'),
            'description'=>'Here is where you may upload Introductory Lessons for your Course',
        ]);
    }

    public function updating(Course $course)
    {
        $course->slug = \Str::slug($course->slug);
        // Don't generate new slug when the slug is same as old.
        if($course->slug != $course->getOriginal('slug'))
        {
           $course->slug = Helper::slugify($course->slug, Course::class);
        } 
    }
}
