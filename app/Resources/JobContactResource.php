<?php

namespace App\Resources;

use JetBrains\PhpStorm\ArrayShape;

class JobContactResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    #[ArrayShape(['id' => 'mixed', 'first_name' => 'mixed', 'last_name' => 'mixed', 'contact_number' => 'mixed', 'preferred_contact_time' => 'mixed'])]
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'contact_number' => $this->resource->contact_number,
            'preferred_contact_time' => $this->resource->preferred_time_to_call,
        ];
    }
}
