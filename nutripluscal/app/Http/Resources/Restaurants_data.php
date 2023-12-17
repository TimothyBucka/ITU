<?php
// ######################################### FILE: restaurants.vue ###############################################
// Authors: Adam Pap (xpapad11)
// ############################################################################################################### 

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Restaurants_data extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    public function with($request): array // add other stuff with the data which are returned by the toArray method
    {
        return [
            'version' => '1.0.0',
            'author_url' => url('http://localhost:8000')
        ];
    }
}
