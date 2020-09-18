<?php

namespace App\Models;

use App\Observers\FeatureObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use HasFactory, SoftDeletes;

    public static function boot()
    {
        parent::boot();
        Feature::observe(new FeatureObserver());
    }

    public const VALIDATION = [
        'name' => ['required', 'string', 'unique:features,name'],
        'slug' => ['string'],
        'status' => ['string', 'in:active,inactive,pending,canceled'],
        'types' => ['array'],
        'types.*' => ['numeric', 'exists:types,id']
    ];

    protected $fillable = ['name', 'slug', 'status'];

    public function types()
    {
        return $this->belongsToMany(Type::class);
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }
}
