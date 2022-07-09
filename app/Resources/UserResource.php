<?php

namespace App\Resources;

use JetBrains\PhpStorm\ArrayShape;

class UserResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    #[ArrayShape(['id' => 'mixed', 'first_name' => 'mixed', 'last_name' => 'mixed', 'email' => 'mixed'])]
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'email' => $this->resource->email,
        ];
    }
}
