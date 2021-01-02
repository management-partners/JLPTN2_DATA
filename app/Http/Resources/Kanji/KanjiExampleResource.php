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
            'id'        => $this->id,
            'category'  =>$this->category,
            'chapterEx'   => $this->chapterEx,
            'content'   => $this->content,
            'onRead'    => $this->onRead,
            'kunRead'   => $this->kunRead,
            'otherRead' =>$this->otherRead,
            'mean'      => $this->mean,
        ];
    }
}
