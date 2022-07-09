<?php

namespace Tests\Feature;

use App\Enums\JobStatus;
use App\Models\User;
use App\Resources\JobResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Config;
use Laravel\Sanctum\Sanctum;
use Tests\FeatureTest;

class JobListFeatureTest extends FeatureTest
{
    private User $user;

    private Collection $jobs;

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
    public function shouldListJobsForAGivenUserBusiness()
    {
        Sanctum::actingAs($this->user);

        $response = $this->json('GET', '/api/jobs');
        $data = ($response->json())['data'];
        $response->assertStatus(200);
        self::assertIsArray($data);
        self::assertCount(Config::get('app.perPage'), $data);
    }

    /**
     * @test
     */
    public function shouldReturnSortedListOfJobsForGivenUserBusiness()
    {
        //arrange
        Sanctum::actingAs($this->user);

        $job_resource = collect(JobResource::collection($this->jobs));
        $sorted_jobs = $job_resource->sortBy('label');
        $sorted_job_ids = array_slice($sorted_jobs->pluck('id')->toArray(), 0, 10);

        //act
        $response = $this->json('GET', '/api/jobs', ['sort' => 'label']);
        $data = collect(($response->json())['data']);
        $data_ids = $data->pluck('id')->toArray();

        //assert
        $response->assertStatus(200);
        // compare the 2 sets of ids should be the same
        self::assertTrue($sorted_job_ids == $data_ids);
    }

    /**
     * @test
     */
    public function shouldReturnFilteredListOfJobsForGivenUserBusiness()
    {
        //arrange
        $query = 'as';
        Sanctum::actingAs($this->user);

        $job_resource = collect(JobResource::collection($this->jobs));
        $sorted_jobs = $job_resource->filter(function ($job) use ($query) {
            return stripos($job['label'], $query) !== false;
        });
        $sorted_job_ids = array_slice($sorted_jobs->pluck('id')->toArray(), 0, 10);
        //act
        $response = $this->json('GET', '/api/jobs', ['q' => $query]);
        $data = collect(($response->json())['data']);
        $data_ids = $data->pluck('id')->toArray();

        //assert
        $response->assertStatus(200);
        // compare the 2 sets of ids should be the same
        self::assertTrue($sorted_job_ids == $data_ids);
    }

    /**
     * @test
     */
    public function shouldReturnStatusFilteredListOfJobsForGivenUserBusiness()
    {
        //arrange
        $status = JobStatus::Active;
        Sanctum::actingAs($this->user);

        $job_resource = collect(JobResource::collection($this->jobs));
        $sorted_jobs = $job_resource->filter(function ($job) use ($status) {
            return $job['status']->value === $status->value;
        });
        $sorted_job_ids = array_slice($sorted_jobs->pluck('id')->toArray(), 0, 10);

        //act
        $response = $this->json('GET', '/api/jobs', ['status' => $status->value]);
        $data = collect(($response->json())['data']);
        $data_ids = $data->pluck('id')->toArray();

        //assert
        $response->assertStatus(200);
        // compare the 2 sets of ids should be the same
        self::assertTrue($sorted_job_ids == $data_ids);
    }

    /**
     * @test
     */
    public function shouldReturnErrorMessageGivenSortInvalid()
    {
        Sanctum::actingAs($this->user);

        //act
        $response = $this->json('GET', '/api/jobs', ['sort' => 'invalid']);
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors', 'errors' => ['sort']], $response->json());
    }

    protected function setUpTestData()
    {
        $business = $this->createBusiness();
        $this->user = $this->createUser($business);
        $this->jobs = $this->createJob($business, 25);
    }
}
