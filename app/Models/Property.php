<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    public const VALIDATION = [
        'type_id' => ['string', 'exist:types,id'],
        'name' => ['string', 'unique:properties,id'],
        'slug' => ['string'],
        'price' => ['numeric', 'min:1'],
        'general_price' => ['numeric', 'min:1','gte:price|min:0'],
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
}
