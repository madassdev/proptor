<?php

namespace App\Http\Requests;

use App\Models\Plan;
use Illuminate\Foundation\Http\FormRequest;

class PlanCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        return $user->can('add-plan');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Plan::VALIDATION;
        $rules['name'] = ['required', 'string', 'unique:plans,name,NULL,id'];
        $rules['duration'] = ['required', 'numeric','min:1'];
        return $rules;
    }
}
