<?php

namespace App\Http\Requests;

use App\Models\Lesson;
use Illuminate\Foundation\Http\FormRequest;

class LessonCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->guard('api')->user();
        $course = $this->route('course');
        $module = $this->route('module');
        return 
            // User is a Tutor
            ($user->tutor and 
            // Tutor owns Course 
            $course->tutor_id == $user->tutor->id and 
            // Module belongs to Course
            $module->course_id == $course->id) or
            //  User is Admin
            ($user->hasRole('admin'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Fetch the Module's Lessons to be used for unique validation, and pass it down the 
        // request object for use in the controller without having to query database again.
        $this->lessons = $lessons = $this->route('module')->lessons;

        // Custom Validation rule for unique title in this Module's Lessons
        $unique_validator = ['title' => ['required', function ($attribute, $value, $fail) use($lessons){
            // Check Lessons for existing title
            if($lessons->contains('title', $value)){
                $fail('The Lesson '.$attribute.' already exists.');
            }
        }]];
        return array_replace(Lesson::VALIDATION, $unique_validator);
    }
}
