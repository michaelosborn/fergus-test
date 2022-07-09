<?php

namespace App\Contracts\Services;

use App\Http\Requests\JobListRequest;
use App\Http\Requests\UpdateJobStatusRequest;
use App\Models\Job;

interface IJobService
{
    /**
     * @param  JobListRequest  $request
     * @return mixed
     */
    public function getListOfJobs(JobListRequest $request);

    /**
     * @param  int  $id
     * @param  int  $business_id
     * @return Job
     */
    public function getJob(int $id, int $business_id): Job;

    /**
     * @param  Job  $job
     * @param  UpdateJobStatusRequest  $request
     * @return Job
     */
    public function updateJobStatus(Job $job, UpdateJobStatusRequest $request): Job;
}
