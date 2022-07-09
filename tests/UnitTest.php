<?php

namespace Tests;

use App\Models\Business;
use App\Models\Job;
use App\Models\JobNote;
use App\Models\User;

abstract class UnitTest extends TestCase
{
    /**
     * @return Business
     */
    protected function makeBusiness(): Business
    {
        return Business::factory()->make(['id' => 1]);
    }

    protected function makeUser(Business $business): User
    {
        $business_id = $business->id;
        $user = User::factory()->make(['business_id' => $business_id]);

        return $user;
    }

    protected function makeJob(Business $business, $job_count = 1)
    {
        $business_id = $business->id;

        return Job::factory($job_count)
            ->make([
                'business_id' => $business_id,
            ]);
    }

    protected function makeJobNote(Job $job, User $user)
    {
        return JobNote::factory()
            ->make([
                'job_id' => $job->id,
                'created_by_user_id' => $user->id,
            ]);
    }
}
