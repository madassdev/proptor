<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
                'name'=>$this->name,
                'slug'=>$this->slug,
                'products_count'=>$this->products_count,
                // 'products'=> sizeof($this->products ?? []) == 0 ? null :ProductMiniResource::collection($this->products),
                'description'=>$this->description,
                'status'=>$this->status,
                'image_url'=>$this->image_url,
                'created_at'=>$this->created_at->diffForHumans(),
        ];
    }
}
