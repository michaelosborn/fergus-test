<?php

namespace App\Repositories;

use App\Models\JobNote;

class JobNoteRepository extends Repository implements \App\Contracts\Repositories\IJobNoteRepository
{
    /**
     * @param  JobNote|null  $model
     */
    public function __construct(JobNote $model = null)
    {
        parent::__construct($model ?? new JobNote());
    }
}
