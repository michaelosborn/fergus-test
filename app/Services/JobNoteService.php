<?php

namespace App\Services;

use App\Contracts\Repositories\IJobNoteRepository;
use App\Events\JobNoteCreated;
use App\Events\JobNoteUpdated;
use App\Http\Requests\StoreJobNoteRequest;
use App\Http\Requests\UpdateJobNoteRequest;
use App\Models\Job;
use App\Models\JobNote;

class JobNoteService implements \App\Contracts\Services\IJobNoteService
{
    private IJobNoteRepository $jobNoteRepository;

    public function __construct(IJobNoteRepository $jobNoteRepository)
    {
        $this->jobNoteRepository = $jobNoteRepository;
    }

    /**
     * @param  Job  $job
     * @param  StoreJobNoteRequest  $request
     * @return JobNote
     *
     * @throws \Throwable
     */
    public function createJobNote(Job $job, StoreJobNoteRequest $request): JobNote
    {
        /** @var JobNote $jobNote */
        $jobNote = $this->jobNoteRepository->create([
            'job_id' => $job->id,
            'note' => $request->getNote(),
            'created_by_user_id' => $request->getUser()->id,
        ]);

        event(new JobNoteCreated($jobNote));

        return $jobNote;
    }

    /**
     * @param  JobNote  $jobNote
     * @param  UpdateJobNoteRequest  $request
     * @return JobNote
     */
    public function updateJobNote(JobNote $jobNote, UpdateJobNoteRequest $request): JobNote
    {
        /** @var JobNote $updatedJobNote */
        $updatedJobNote = $this->jobNoteRepository->update($jobNote, ['note' => $request->getNote()]);

        if (! is_null($updatedJobNote)) {
            event(new JobNoteUpdated($updatedJobNote));
        }

        return $updatedJobNote ?? $jobNote;
    }
}
