<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaystackRecurrent extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    protected $fillable = [
        'user_id',
        'authorization_code',
        'last4',
        'bin',
        'exp_month',
        'exp_year',
        'channel',
        'card_type',
        'bank',
        'signature',
        'reusable'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
