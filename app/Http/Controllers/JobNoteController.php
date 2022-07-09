<?php

namespace App\Http\Controllers;

use App\Contracts\Services\IJobNoteService;
use App\Http\Requests\StoreJobNoteRequest;
use App\Http\Requests\UpdateJobNoteRequest;
use App\Models\Job;
use App\Models\JobNote;
use App\Resources\JobNoteResource;

class JobNoteController extends Controller
{
    private IJobNoteService $jobNoteService;

    public function __construct(IJobNoteService $jobNoteService)
    {
        $this->jobNoteService = $jobNoteService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreJobNoteRequest  $request
     * @return JobNoteResource
     */
    public function store(StoreJobNoteRequest $request, Job $job): JobNoteResource
    {
        $jobNote = $this->jobNoteService->createJobNote($job, $request);

        return JobNoteResource::make($jobNote);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJobNoteRequest  $request
     * @param  Job  $job
     * @param  JobNote  $jobNote
     * @return JobNoteResource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateJobNoteRequest $request, Job $job, JobNote $jobNote): JobNoteResource
    {
        $this->authorize('update', [$jobNote, $job]);
        $jobNote = $this->jobNoteService->updateJobNote($jobNote, $request);

        return JobNoteResource::make($jobNote);
    }
}
