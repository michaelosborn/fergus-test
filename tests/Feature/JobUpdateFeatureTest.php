<?php

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Tests\FeatureTest;

class JobUpdateFeatureTest extends FeatureTest
{
    private mixed $job;

    private \App\Models\User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpTestData();
    }

    /**
     * @test
     *
     * @return void
     */
    public function shouldReturnValidationMessageGivenInvalidStatus()
    {
        Sanctum::actingAs($this->user);
        $response = $this->json('patch', '/api/jobs/'.$this->job->id.'/status', ['status' => 111]);
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors' => ['status']]);
    }

    protected function setUpTestData()
    {
        $business = $this->createBusiness();
        $this->user = $this->createUser($business);
        $this->job = $this->createJob($business)->first();
    }
}
