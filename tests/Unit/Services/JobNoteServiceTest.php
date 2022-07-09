<?php

namespace Tests\Unit\Services;

use App\Contracts\Repositories\IJobNoteRepository;
use App\Events\JobNoteCreated;
use App\Events\JobNoteUpdated;
use App\Http\Requests\StoreJobNoteRequest;
use App\Http\Requests\UpdateJobNoteRequest;
use App\Models\Job;
use App\Models\JobNote;
use App\Models\User;
use App\Services\JobNoteService;

class JobNoteServiceTest extends \Tests\UnitTest
{
    /**
     * @test
     */
    public function shouldCallCreateOnJobNoteRepository()
    {
        $this->withoutEvents();
        $user = User::factory()->make(['id' => 1]);
        $job = Job::factory()->make(['id' => 1]);
        $jobNote = JobNote::factory()->make();

        $mockedRequest = $this->mock(StoreJobNoteRequest::class);
        $mockedRequest->shouldReceive('getNote')->andReturn('This is the note');
        $mockedRequest->shouldReceive('getUser')->andReturn($user);
        $mockedJobNoteRepository = $this->mock(IJobNoteRepository::class);
        $mockedJobNoteRepository->shouldReceive('create')->andReturn($jobNote);
        $service = new JobNoteService($mockedJobNoteRepository);
        $service->createJobNote($job, $mockedRequest);
    }

    /**
     * @test
     */
    public function shouldFireJobNoteCreatedEventGivenJobNoteCreated()
    {
        $user = User::factory()->make(['id' => 1]);
        $job = Job::factory()->make(['id' => 1]);
        $jobNote = JobNote::factory()->make();

        $this->expectsEvents([JobNoteCreated::class]);
        $mockedRequest = $this->mock(StoreJobNoteRequest::class);
        $mockedRequest->shouldReceive('getNote')->andReturn('This is the note');
        $mockedRequest->shouldReceive('getUser')->andReturn($user);
        $mockedJobNoteRepository = $this->mock(IJobNoteRepository::class);
        $mockedJobNoteRepository->shouldReceive('create')->andReturn($jobNote);
        $service = new JobNoteService($mockedJobNoteRepository);
        $service->createJobNote($job, $mockedRequest);
    }

    /**
     * @test
     */
    public function shouldReturnOriginalJobNoteGivenDataWasntChanged()
    {
        $jobNote = JobNote::factory()->make();

        $mockedJobNoteRepository = $this->mock(IJobNoteRepository::class);
        $mockedJobNoteRepository->shouldReceive('update')->andReturnNull();

        $mockedRequest = $this->mock(UpdateJobNoteRequest::class);
        $mockedRequest->shouldReceive('getNote')->andReturn('This is the note');

        $this->doesntExpectEvents([JobNoteUpdated::class]);

        $service = new JobNoteService($mockedJobNoteRepository);
        $service->updateJobNote($jobNote, $mockedRequest);
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function shouldFireJobNoteUpdatedEventGivenJobNoteUpdated()
    {
        $jobNote = JobNote::factory()->make();
        $mockedJobNoteRepository = $this->mock(IJobNoteRepository::class);
        $mockedJobNoteRepository->shouldReceive('update')
            ->andReturn($jobNote->fill(['note' => 'this has changed']));

        $mockedRequest = $this->mock(UpdateJobNoteRequest::class);
        $mockedRequest->shouldReceive('getNote')->andReturn('This is the note');

        $this->expectsEvents([JobNoteUpdated::class]);

        $service = new JobNoteService($mockedJobNoteRepository);
        $service->updateJobNote($jobNote, $mockedRequest);
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function shouldReturnUpdatedJobGivenJobNoteUpdated()
    {
        $this->withoutEvents();
        $jobNote = JobNote::factory()->make();
        $mockedJobNoteRepository = $this->mock(IJobNoteRepository::class);
        $mockedJobNoteRepository->shouldReceive('update')->andReturn($jobNote->fill(['note' => 'this has changed']));

        $mockedRequest = $this->mock(UpdateJobNoteRequest::class);
        $mockedRequest->shouldReceive('getNote')->andReturn('This is the note');

        $service = new JobNoteService($mockedJobNoteRepository);
        $service->updateJobNote($jobNote, $mockedRequest);
    }
}
