<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryMiniResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
                'id'=>$this->id,
                'products_count'=>$this->products_count,
                'name'=>$this->name,
                'slug'=>$this->slug,
                'description'=>$this->description,
                'image_url'=>$this->image_url
        ];
    }
}
