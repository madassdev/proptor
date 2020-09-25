<?php

namespace App\Services;
    
use Illuminate\Support\Facades\Validator;

class AgentService
{
    public static function createUser($user_data)
    {
        $rules = [
            "email" => "required"
        ];
        $validator = Validator::make($user_data, $rules); 
        abort_if($validator->fails(), 422, "Failed");
    }
}