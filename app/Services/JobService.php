<?php

namespace App\Services;

use App\Contracts\Repositories\IJobRepository;
use App\Events\JobStatusChanged;
use App\Http\Requests\JobListRequest;
use App\Http\Requests\UpdateJobStatusRequest;
use App\Models\Job;
use Illuminate\Support\Facades\Config;

class JobService implements \App\Contracts\Services\IJobService
{
    private IJobRepository $jobRepository;

    public function __construct(IJobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    /**
     * @param  int  $business_id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getListOfJobs(JobListRequest $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->jobRepository->getListOfJobs($request)
            ->paginate(Config::get('app.perPage'));
    }

    /**
     * @param  int  $id
     * @param  int  $business_id
     * @return Job
     */
    public function getJob(int $id, int $business_id): Job
    {
        return $this->jobRepository
            ->getByIdForBusiness($id, $business_id)
            ->first();
    }

    /**
     * @param  Job  $job
     * @param  UpdateJobStatusRequest  $request
     * @return Job
     */
    public function updateJobStatus(Job $job, UpdateJobStatusRequest $request): Job
    {
        $job->status = $request->getStatus();

        if ($job->isDirty(['status'])) {
            event(new JobStatusChanged($job, $request));
        }

        $job->save();

        return $job;
    }
}
