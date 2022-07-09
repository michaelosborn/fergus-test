<?php

namespace App\Resources;

use JetBrains\PhpStorm\ArrayShape;

class JobNoteResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    #[ArrayShape(['id' => 'mixed', 'note' => 'mixed', 'created_by_user' => "\App\Resources\UserResource"])]
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'note' => $this->resource->note,
            'created_by_user' => UserResource::make($this->resource->user),
        ];
    }
}
