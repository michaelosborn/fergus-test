<?php

namespace Tests;

use App\Models\Business;
use App\Models\Job;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Foundation\Testing\Traits\CanConfigureMigrationCommands;

abstract class FeatureTest extends TestCase
{
    use CanConfigureMigrationCommands;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->runDatabaseMigrations();
    }

    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function runDatabaseMigrations()
    {
        $this->artisan('migrate:fresh', $this->migrateFreshUsing());

        $this->app[Kernel::class]->setArtisan(null);

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('db:wipe');
            RefreshDatabaseState::$migrated = false;
        });
    }

    abstract protected function setUpTestData();

    /**
     * @return Business
     */
    protected function createBusiness(): Business
    {
        return Business::factory()->create();
    }

    /**
     * @param  Business  $business
     * @return User
     */
    protected function createUser(Business $business): User
    {
        return User::factory()->create([
            'business_id' => $business->id,
        ]);
    }

    /**
     * @param  Business  $business
     * @return Collection
     */
    protected function createJob(Business $business, $job_count = 1): Collection
    {
        return Job::factory($job_count)
            ->hasNotes(1, function (array $attributes, Job $job) {
                $user = User::where('business_id', '=', $job->business_id)->first();

                return ['created_by_user_id' => $user->id];
            })
            ->create([
                'business_id' => $business->id,
            ]);
    }
}
