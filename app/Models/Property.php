<?php

namespace App\Models;

use App\Observers\PropertyObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    public static function boot()
    {
        parent::boot();
        Property::observe(new PropertyObserver());
    }

    public const VALIDATION = [
        'status' => ['string', 'in:active,inactive,pending,canceled'],
        'type' => ['required', 'string', 'in:land,rent,property,building'],
        'name' => ['string', 'unique:properties,id'],
        'slug' => ['string'],
        'price' => ['required', 'sometimes', 'numeric', 'min:1'],
        'general_price' => ['numeric', 'min:1','gte:price|min:0'],
        'units' => ['numeric', 'min:1', 'nullable'],
        'description' => ['string', 'nullable'],
        'short_description' => ['string', 'nullable'],

        'image_url' => ['string', 'nullable'],
        'gallery_images_url' => ['string', 'nullable'],

        'state' => ['string', 'nullable'],
        'address' => ['string', 'nullable'],
        'lga' => ['string', 'nullable'],

        'length' => ['string', 'nullable'],
        'width' => ['string', 'nullable'],
        'size' => ['numeric', 'nullable'],
        'lat' => ['string', 'nullable'],
        'long' => ['string', 'nullable'],

        'bedrooms' => ['string', 'nullable'],
        'bathrooms' => ['string', 'nullable'],


        'features' => ['array', 'nullable'],
        'features.*' => ['string', 'nullable'],
        'plans' => ['required','array', 'nullable'],
        'plans.*' => ['numeric', 'exists:plans,id', 'nullable']
    ];
    
    protected $fillable = [
        'name',
        'slug',
        'status',
        'type',
        'price',
        'general_price',
        'units',
        'description',
        'short_description',
        'state',
        'size',
        'address',
        'image_url',
        'gallery_images_url',
    ];

    protected $casts = [
        'image_url' => 'array',
        'gallery_images_url' => 'array',
    ];

    public function plans()
    {
        return $this->belongsToMany(Plan::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function type()
    {
        return $this->belongsTo((Type::class));
    }

    //Get the minimum payable amount.
    public function min_payable(Plan $plan)
    {
        return $plan->extra_interest;
    }

}
