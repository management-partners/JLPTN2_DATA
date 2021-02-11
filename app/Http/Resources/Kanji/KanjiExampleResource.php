<?php

namespace App\Http\Resources\Kanji;

use Illuminate\Http\Resources\Json\JsonResource;

class KanjiExampleResource extends JsonResource
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
            'autoId'    => $this->autoId,
            'id'        => $this->id,
            'cateId'    => $this->cateId,
            'chapterName' => $this->chapterName,
            'content'   => $this->content,
            'hanviet'   => $this->hanviet,
            'onRead'    => $this->onRead,
            'kunRead'   => $this->kunRead,
            'otherRead' => $this->otherRead,
            'mean'      => $this->mean,
        ];
    }
}
