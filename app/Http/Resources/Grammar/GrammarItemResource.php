<?php

namespace App\Http\Resources\Grammar;

use Illuminate\Http\Resources\Json\JsonResource;

class GrammarItemResource extends JsonResource
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
            'id'     => $this->id,
            'text'   => $this->structs,
        ];
    }
}
