<?php

namespace Tests\Unit\Policies;

use App\Policies\JobPolicy;
use Tests\UnitTest;

class JobPolicyTest extends UnitTest
{
    /**
     * @test
     */
    public function shouldReturnTrueGivenJobBelongToUserAndBusiness()
    {
        $business = $this->makeBusiness();
        $user = $this->makeUser($business);
        $job = $this->makeJob($business)->first();
        $policy = new JobPolicy();
        self::assertTrue($policy->update($user, $job));
    }
}
