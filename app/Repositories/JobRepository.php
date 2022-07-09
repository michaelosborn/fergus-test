<?php

namespace App\Repositories;

use App\Enums\JobStatus;
use App\Http\Requests\JobListRequest;
use App\Models\Job;
use Illuminate\Database\Eloquent\Builder;

class JobRepository extends Repository implements \App\Contracts\Repositories\IJobRepository
{
    public function __construct(Job $model = null)
    {
        parent::__construct($model ?? new Job());
    }

    /**
     * {@inheritDoc}
     */
    public function getListOfJobs(JobListRequest $request)
    {
        $builder = $this->getByBusiness($request->getBusinessId())
                ->orderBy($request->getSortBy(), $request->getSortDirection());

        $this->applyFilter($request, $builder);
        $this->applyStatus($request, $builder);

        return $builder;
    }

    /**
     * {@inheritDoc}
     */
    public function getByIdForBusiness(int $id, int $business_id, array $relations = []): Builder
    {
        return $this->getByBusiness($business_id, $relations)
            ->where('id', '=', $id)
            ->with($relations);
    }

    /**
     * {@inheritDoc}
     */
    public function getByBusiness(int $business_id, array $relations = []): Builder
    {
        return $this->model?->newQuery()
            ->where('business_id', '=', $business_id)
            ->with($relations);
    }

    /**
     * @param  JobListRequest  $request
     * @param  Builder  $builder
     */
    private function applyFilter(JobListRequest $request, Builder &$builder)
    {
        if ($request->getQuery()) {
            $builder->where(function ($query) use ($request) {
                $query->where('label', 'LIKE', '%'.strtolower($request->getQuery()).'%');
                $query->whereOr('created_at', 'LIKE', '%'.strtolower($request->getQuery()).'%');
            });
        }
    }

    /**
     * @param  JobListRequest  $request
     * @param  Builder  $builder
     */
    private function applyStatus(JobListRequest $request, Builder &$builder)
    {
        if ($request->getStatus()) {
            $builder->where('status', '=', JobStatus::from($request->getStatus()));
        }
    }
}
