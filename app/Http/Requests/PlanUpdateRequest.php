<?php

namespace App\Http\Requests;

use App\Models\Plan;
use Illuminate\Foundation\Http\FormRequest;

class PlanUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        return $user->can('edit-plan');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Plan::VALIDATION;
        $rules['name'] = ['required', 'sometimes', 'string', 'unique:plans,name,'.$this->plan->id.',id,deleted_at,NULL'];
        return $rules;
    }
}
