<?php

namespace App\Http\Resources\Vocabulary;

use Illuminate\Http\Resources\Json\JsonResource;

class VocabularyResource extends JsonResource
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
            'category'  => $this->category,
            'chapter'   => $this->chapter,
            'chapteName'=> $this->chapterName,
            'lesson'    => $this->lesson,
            'vocabulary'=> $this->vocabulary,
            'onRead'    => $this->onRead,
            'mean'      => $this->mean,
        ];
    }
}
