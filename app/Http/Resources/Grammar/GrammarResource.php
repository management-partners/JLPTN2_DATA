<?php

namespace App\Http\Resources\Grammar;

use Illuminate\Http\Resources\Json\JsonResource;

class GrammarResource extends JsonResource
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
            'id'            => $this->id,
            'category'      => $this->category,
            'structs'       => $this->structs,
            'toUser'        => $this->toUse,
            'mean'          => $this->mean,
            'description'   => $this->description,
        ];
    }
}
