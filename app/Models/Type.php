<?php

namespace App\Models;

use App\Observers\TypeObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory, SoftDeletes;

    public static function boot()
    {
        parent::boot();
        Type::observe(new TypeObserver());
    }

    public const VALIDATION = [
        'name' => ['required', 'string', 'unique:features,name'],
        'slug' => ['string'],
        'status' => ['string', 'in:active,inactive,pending,canceled'],
        'features' => ['array'],
        'features.*' => ['numeric', 'exists:features,id']
    ];

    protected $fillable = ['name', 'slug', 'status'];

    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }
}
