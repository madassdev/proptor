<?php

namespace App\Models;

use App\Observers\SaleObserver;
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
        'payment_status'
    ];

    protected $appends = [
        "percent_paid",
        "total_unpaid"
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

    public function getTotalUnpaidAttribute()
    {
        return $this->total_amount - $this->total_paid;
    }

    public static function boot()
    {
        parent::boot();
        Sale::observe(new SaleObserver());
    }
}
