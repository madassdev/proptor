<?php

namespace App\Models;

use App\Observers\PlanObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    public static function boot()
    {
        parent::boot();
        Payment::observe(new PlanObserver());
    }

    public const VALIDATION = [];
    
    protected $fillable = [
        "user_id",
        "sale_id",
        "amount",
        "method",
        "reference",
        "status"
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeMethod($query, $method)
    {
        if($method){

            return $query->where('method', $method);
        }
    }
    
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
