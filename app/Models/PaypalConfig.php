<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaypalConfig extends Model
{
    protected $fillable = [
        "client_id",
        "secret_key"
    ];
}
