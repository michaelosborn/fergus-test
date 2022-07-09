<?php

namespace Tests\Unit\Policies;

use App\Models\Job;
use App\Models\JobNote;
use App\Policies\JobNotePolicy;
use Tests\UnitTest;

class JobNotePolicyTest extends UnitTest
{
    private Job $job;

    private JobNote $jobNote;

    /**
     * @test
     */
    public function shouldReturnTrueGivenJobAndJobNoteBelongToUserAndBusiness()
    {
        $business = $this->makeBusiness();
        $user = $this->makeUser($business);
        $job = $this->makeJob($business)->first();
        $jobNote = $this->makeJobNote($job, $user);
        $policy = new JobNotePolicy();
        self::assertTrue($policy->update($user, $jobNote, $job));
    }
}
