<?php

namespace App\Models;

use App\Observers\PlanObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    public static function boot()
    {
        parent::boot();
        Type::observe(new PlanObserver());
    }

    public const VALIDATION = [
        'name' => ['required', 'sometimes', 'string', 'unique:plans,name,NULL,id,deleted_at,NULL,'],
        'description' => ['string'],
        'extra_interest' => ['required', 'sometimes', 'numeric', 'min:1', 'max:100'],
        'duration' => ['required', 'sometimes', 'numeric', 'min:1'],
        'min_first_payment' => ['required', 'sometimes', 'numeric', 'min:1'],
        'first_payment_formular' => ['required', 'sometimes', 'string', 'in:percentage,static-price'],
        'status' => ['string', 'in:active,inactive,pending,canceled'],
    ];

    protected $fillable = ['name', 'description', 'extra_interest', 'duration', 'status', 'min_first_payment', 'first_payment_formular'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }

}
