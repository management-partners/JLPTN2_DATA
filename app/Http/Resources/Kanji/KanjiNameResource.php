<?php

namespace App\Http\Resources\Kanji;

use Illuminate\Http\Resources\Json\JsonResource;

class KanjiNameResource extends JsonResource
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
            'id'    => $this->id,
            'text' => $this->kanji,
        ];
    }
}
