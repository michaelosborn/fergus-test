<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\FeatureTest;

class JobNoteAddFeatureTest extends FeatureTest
{
    private User $user;

    private Job $job;

    private string $url;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpTestData();
        $this->url = '/api/jobs/'.$this->job->id.'/notes';
    }

    /**
     * @test
     *
     * @return void
     */
    public function shouldReturnSuccess()
    {
        Sanctum::actingAs($this->user);
        $response = $this->json('POST', $this->url, ['note' => 'this is a new note']);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'note',
                'created_by_user' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function shouldReturnValidationErrorMessageWhenNoNoteProvided()
    {
        Sanctum::actingAs($this->user);
        $response = $this->json('POST', $this->url, []);
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors' => ['note']]);
    }

    protected function setUpTestData()
    {
        $business = $this->createBusiness();
        $this->user = $this->createUser($business);
        $this->job = $this->createJob($business)->first();
    }
}
