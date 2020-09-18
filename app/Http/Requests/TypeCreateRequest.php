<?php

namespace App\Http\Requests;

use App\Models\Type;
use Illuminate\Foundation\Http\FormRequest;

class TypeCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        return $user->can('add-type');

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Type::VALIDATION;
    }
}
