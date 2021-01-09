<?php

namespace App\Http\Resources\Lookandlearn;

use Illuminate\Http\Resources\Json\JsonResource;

class LookAndLearnResource extends JsonResource
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
            'cateId'        => $this->cateId,
            'category'      => $this->category,
            'chapter'       => $this->chapter,
            'chapterName'   => $this->chapterName,
            'kanji'         => $this->kanji,
            'image'         => $this->image,
            'hanviet'       => $this->hanviet,
            'description'   => $this->description,
            'onRead'        => $this->onRead,
            'kunRead'       => $this->kunRead,
            'otherRead'     => $this->otherRead,
            'mean'          => $this->mean,
        ];
    }
}
