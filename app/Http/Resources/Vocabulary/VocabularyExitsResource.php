<?php

namespace App\Http\Resources\Vocabulary;

use Illuminate\Http\Resources\Json\JsonResource;

class VocabularyExitsResource extends JsonResource
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
            'id'      => $this->id,
            'text'    => $this->vocabulary,
        ];
    }
}
