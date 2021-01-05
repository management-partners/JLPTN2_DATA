<?php

namespace App\Http\Resources\Grammar;

use Illuminate\Http\Resources\Json\JsonResource;

class GrammarExampleResource extends JsonResource
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
            'productId'     => $this->productId,
            'chapterName'   => $this->chapterName,
            'cate'          => $this->cate,
            'title'         => $this->title,
            'toRead'        => $this->toRead,
            'mean'          => $this->mean,
        ];
    }
}
