<?php

namespace App\Resources;

use JetBrains\PhpStorm\ArrayShape;

class JobStatusResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    #[ArrayShape(['id' => 'mixed', 'label' => 'mixed'])]
    public function toArray($request): array
    {
        return [
            'id' => $this->resource,
            'label' => $this->resource->forDisplay(),
        ];
    }
}
