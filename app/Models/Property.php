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
        'units' => ['numeric', 'min:1'],
        'description' => ['string'],
        'short_description' => ['string'],

        'image_url' => ['string'],
        'gallery_images_url' => ['string'],

        'state' => ['string'],
        'address' => ['string'],
        'lga' => ['string'],

        'length' => ['string'],
        'width' => ['string'],
        'size' => ['string'],
        'lat' => ['string'],
        'long' => ['string'],

        'bedrooms' => ['string'],
        'bathrooms' => ['string'],


        'features' => ['array'],
        'features.*' => ['string'],
        'plans' => ['required','array'],
        'plans.*' => ['numeric', 'exists:plans,id']
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
        'address',
        'image_url',
        'gallery_images_url',
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
