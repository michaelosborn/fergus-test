<?php

namespace App\Contracts\Repositories;

use App\Http\Requests\JobListRequest;
use Illuminate\Database\Eloquent\Builder;

interface IJobRepository extends IRepository
{
    /**
     * @param  JobListRequest  $request
     * @return mixed
     */
    public function getListOfJobs(JobListRequest $request);

    /**
     * @param  int  $id
     * @param  int  $business_id
     * @return Builder
     */
    public function getByIdForBusiness(int $id, int $business_id): Builder;

    /**
     * @param  int  $business_id
     * @return mixed
     */
    public function getByBusiness(int $business_id): Builder;
}
