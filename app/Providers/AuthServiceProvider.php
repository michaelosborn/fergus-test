<?php

namespace App\Providers;

use App\Models\Business;
use App\Models\Job;
use App\Models\JobNote;
use App\Policies\BusinessPolicy;
use App\Policies\JobNotePolicy;
use App\Policies\JobPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Job::class => JobPolicy::class,
        Business::class => BusinessPolicy::class,
        JobNote::class => JobNotePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
