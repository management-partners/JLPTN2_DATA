<?php

namespace App\Http\Resources\Vocabulary;

use Illuminate\Http\Resources\Json\JsonResource;

class VocabularyExampleResource extends JsonResource
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
            'vocalId'   => $this->vocalId,
            'cateId'    => $this->cateId,
            'chapter'   => $this->chapter,
            'chapterEx' => $this->chapterEx,
            'content'   => $this->content,
            'onRead'    => $this->onRead,
            'mean'      => $this->mean,
        ];
    }
}
