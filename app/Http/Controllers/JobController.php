<?php

namespace App\Http\Controllers;

use App\Contracts\Services\IJobService;
use App\Http\Requests\JobListRequest;
use App\Http\Requests\UpdateJobStatusRequest;
use App\Models\job;
use App\Resources\JobResource;
use Illuminate\Auth\Access\AuthorizationException;

class JobController extends Controller
{
    private IJobService $jobService;

    public function __construct(IJobService $jobService)
    {
        $this->jobService = $jobService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(JobListRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $jobs = $this->jobService->getListOfJobs($request);

        return JobResource::collection($jobs);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\job  $job
     * @return JobResource
     *
     * @throws AuthorizationException
     */
    public function show(job $job): JobResource
    {
        $this->authorize('view', $job);

        return JobResource::make($job);
    }

    /**
     * Update the status of the resource
     *
     * @param  \App\Http\Requests\UpdateJobStatusRequest  $request
     * @param  \App\Models\job  $job
     * @return JobResource
     *
     * @throws AuthorizationException
     */
    public function updateStatus(UpdateJobStatusRequest $request, job $job): JobResource
    {
        $this->authorize('update', $job);

        $job = $this->jobService->updateJobStatus($job, $request);

        return JobResource::make($job);
    }
}
