<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\JobNote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobNotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobNote  $jobNote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, JobNote $jobNote, Job $job): \Illuminate\Auth\Access\Response|bool
    {
        return ($user->business_id === $job->business_id) && ($jobNote->job_id === $job->id);
    }
}
