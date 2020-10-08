<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlutterwaveConfig extends Model
{

    protected $fillable = ["public_key", "secret_key", "encryption_key"];

    public function store()
    {
        return $this->belongsTo(Main\Store::class);
    }
}
