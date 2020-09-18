<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Course;
use App\Services\Helper;

class CategoryService
{
    public function create($data)
    {
        $slug = Helper::slugify($data['name'], \App\Models\Category::class);

        $data['slug'] = array_key_exists('slug', $data) ? Helper::slugify($data['slug'], \App\Models\Category::class): $slug;

        $category = Category::create($data);

        return $category;
    }

    public function update(Category $category, $request)
    {
        $data = $request->all();

        if(array_key_exists('slug', $data)){
            $data['slug'] = Helper::slugify($data['slug'], \App\Models\Category::class);
        }

        $category->update($data);

        if($request->has('courses')){
            $courses = Course::find($request->courses);
            $category->courses()->sync($courses);
        }

        return $category;
    }

}
