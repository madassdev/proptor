<?php

namespace App\Http\Requests;

use App\Models\Feature;
use Illuminate\Foundation\Http\FormRequest;

class FeatureUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        return $user->can('edit-type');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Feature::VALIDATION;
    }
}
