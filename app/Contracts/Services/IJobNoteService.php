<?php

namespace App\Contracts\Services;

use App\Http\Requests\StoreJobNoteRequest;
use App\Http\Requests\UpdateJobNoteRequest;
use App\Models\Job;
use App\Models\JobNote;

interface IJobNoteService
{
    /**
     * @param  Job  $job
     * @param  StoreJobNoteRequest  $request
     * @return JobNote
     */
    public function createJobNote(Job $job, StoreJobNoteRequest $request): JobNote;

    /**
     * @param  JobNote  $jobNote
     * @param  UpdateJobNoteRequest  $request
     * @return JobNote
     */
    public function updateJobNote(JobNote $jobNote, UpdateJobNoteRequest $request): JobNote;
}
