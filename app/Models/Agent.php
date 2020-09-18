<?php

namespace App\Models;

use App\Observers\AgentObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use HasFactory, SoftDeletes;

    public static function boot()
    {
        parent::boot();
        Agent::observe(new AgentObserver());
    }

    public const VALIDATION = [];
    
    protected $fillable = ['name', 'description', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
