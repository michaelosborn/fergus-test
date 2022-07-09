<?php

namespace Tests\Feature;

use App\Events\JobNoteUpdated;
use App\Models\Job;
use App\Models\JobNote;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\FeatureTest;

class JobNoteUpdateFeatureTest extends FeatureTest
{
    private User $user;

    private Job $job;

    private JobNote $jobNotes;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpTestData();
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws \Exception
     */
    public function shouldReturnSuccess()
    {
        Sanctum::actingAs($this->user);
        $newNote = 'This has changed';
        $url = '/api/jobs/'.$this->jobNotes->job_id.'/notes/'.$this->jobNotes->id;

        $this->expectsEvents([JobNoteUpdated::class]);

        $response = $this->json('PUT', $url, ['note' => $newNote]);
        $response->assertStatus(200);
        $result = (object) ($response->json())['data'];
        self::assertEquals($newNote, $result->note);
    }

    /**
     * @test
     */
    public function shouldReturnValidationMessageWhenNoNoteProvided()
    {
        Sanctum::actingAs($this->user);
        $url = '/api/jobs/'.$this->jobNotes->job_id.'/notes/'.$this->jobNotes->id;

        $response = $this->json('PUT', $url, []);
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors' => ['note']]);
    }

//
    /**
     * @test
     */
    public function shouldReturnAuthExceptionWhenNoteDoesntBelongToUser()
    {
        Sanctum::actingAs($this->user);

        $jobNote = $this->createSecondSetData();

        // note that the JobNote Id does not belong  to $this->jobNote user
        $url = '/api/jobs/'.$this->jobNotes->job_id.'/notes/'.$jobNote->id;

        $response = $this->json('PUT', $url, ['note' => 'This shouldnt change']);
        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
        $result = (object) $response->json();
        self::assertEquals('This action is unauthorized.', $result->message);
    }

    protected function setUpTestData()
    {
        $business = $this->createBusiness();
        $this->user = $this->createUser($business);

        $this->job = $this->createJob($business, 1)->first();
        $this->jobNotes = $this->job->notes->first();
    }

    private function createSecondSetData()
    {
        $business = $this->createBusiness();
        $this->createUser($business);
        $jobs = $this->createJob($business);

        return $jobs->first()->notes->first();
    }
}
