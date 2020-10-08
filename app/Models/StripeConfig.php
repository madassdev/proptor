<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeConfig extends Model
{

    protected $fillable = [
        "publishable_key",
        "secret_key"
    ];
    //
}
