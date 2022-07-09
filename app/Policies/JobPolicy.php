<?php

namespace App\Policies;

use App\Models\job;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\job  $job
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Job $job): \Illuminate\Auth\Access\Response|bool
    {
        return $this->belongsToBusiness($user, $job);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\job  $job
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, job $job): \Illuminate\Auth\Access\Response|bool
    {
        return $this->belongsToBusiness($user, $job);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\job  $job
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, job $job): \Illuminate\Auth\Access\Response|bool
    {
        return $this->belongsToBusiness($user, $job);
    }

    /**
     * @param  User  $user
     * @param  job  $job
     * @return bool
     */
    private function belongsToBusiness(User $user, Job $job): bool
    {
        return $user->business_id === $job->business_id;
    }
}
