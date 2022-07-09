<?php

namespace App\Resources;

use Carbon\Carbon;
use JetBrains\PhpStorm\ArrayShape;

class JobResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    #[ArrayShape(['id' => 'mixed', 'label' => 'mixed', 'status' => "\App\Resources\JobStatusResource",
        'description' => 'mixed', 'created_at' => 'string', 'updated_at' => 'string',
        'notes' => "\Illuminate\Http\Resources\MissingValue|mixed",
        'contacts' => "\Illuminate\Http\Resources\MissingValue|mixed", ])]
    public function toArray($request): array
    {
        $with = explode(',', $request->get('with', ''));

        return [
            'id' => $this->resource->id,
            'label' => $this->resource->label,
            'status' => JobStatusResource::make($this->resource->status),
            'description' => $this->resource->description,
            'created_at' => Carbon::createFromDate($this->resource->created_at)->format('d M Y m:h'),
            'updated_at' => Carbon::createFromDate($this->resource->updated_at)->format('d M Y m:h'),
            'notes' => $this->when(in_array('notes', $with), JobNoteResource::collection($this->resource->notes)),
            'contacts' => $this->when(in_array('contacts', $with), JobContactResource::collection($this->resource->contacts)),
        ];
    }
}
