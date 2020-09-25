<?php

namespace App\Models;

use App\Observers\LandObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Land extends Model
{
    use HasFactory, SoftDeletes;

    public static function boot()
    {
        parent::boot();
        Property::observe(new LandObserver());
    }

    public const VALIDATION = [
        'type_id' => ['required', 'sometimes', 'numeric', 'exists:types,id'],
        'name' => ['string', 'unique:properties,id'],
        'slug' => ['string'],
        'price' => ['required', 'sometimes', 'numeric', 'min:1'],
        'general_price' => ['numeric', 'min:1','gte:price|min:0'],
        'units' => ['required', 'sometimes', 'numeric', 'min:1'],
        'description' => ['string'],
        'state' => ['string'],
        'address' => ['string'],
        'image_url' => ['string'],
        'gallery_images_url' => ['string'],
        'features' => ['array'],
        'features.*' => ['numeric', 'exists:features,id'],
        'plans' => ['array'],
        'plans.*' => ['numeric', 'exists:plans,id']
    ];
    
    protected $fillable = [
        'name',
        'type_id',
        'slug',
        'price',
        'general_price',
        'description',
        'short_description',
        'state',
        'address',
        'image_url',
        'gallery_images_url',
        'status'
    ];

    public function plans()
    {
        return $this->belongsToMany(Plan::class);
    }
}
