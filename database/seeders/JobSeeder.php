<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $business_ids = Business::all()->pluck('id');

        Job::factory(50)
            ->hasContacts(1)
            ->hasNotes(2, function (array $attributes, Job $job) {
                $user = User::where('business_id', '=', $job->business_id)->first();

                return ['created_by_user_id' => $user->id];
            })
            ->create([
                'business_id' => array_rand((array) $business_ids, 1),
            ]);
    }
}
