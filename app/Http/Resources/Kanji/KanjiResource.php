<?php

namespace App\Http\Resources\Kanji;

use Illuminate\Http\Resources\Json\JsonResource;

class KanjiResource extends JsonResource
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
            'exampleId'     => $this->exampleId,
            'category'      => $this->category,
            'chapter'       => $this->chapter,
            'chapterName'   => $this->chapterName,
            'kanji'         => $this->kanji,
            'hanviet'       => $this->hanviet,
            'onRead'        => $this->onRead,
            'kunRead'       => $this->kunRead,
            'otherRead'     => $this->otherRead,
            'mean'          => $this->mean,
        ];
    }
}