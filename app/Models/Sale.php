<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    public const VALIDATION = [];
    
    protected $fillable = [
        'user_id',
        'agent_id',
        'property_id',
        'plan_id',
        'next_min_amount',
        'total_amount',
        'code',
    ];

    protected $appends = [
        "percent_paid"
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function min_first_pay()
    {
        return $this->property;
    }

    public function getPercentPaidAttribute()
    {
        return ($this->total_paid * 100)/$this->total_amount;
    }
}
