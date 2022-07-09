<?php

namespace App\Providers;

use App\Contracts\Repositories\IJobNoteRepository;
use App\Contracts\Repositories\IJobRepository;
use App\Contracts\Services\IJobNoteService;
use App\Contracts\Services\IJobService;
use App\Repositories\JobNoteRepository;
use App\Repositories\JobRepository;
use App\Services\JobNoteService;
use App\Services\JobService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IJobRepository::class, JobRepository::class);
        $this->app->bind(IJobService::class, JobService::class);

        $this->app->bind(IJobNoteRepository::class, JobNoteRepository::class);
        $this->app->bind(IJobNoteService::class, JobNoteService::class);
    }
}
