<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Output\ConsoleOutput;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $output = new ConsoleOutput();
        $business_ids = Business::all()->pluck('id');

        $users = \App\Models\User::factory(10)->create([
            'business_id' => array_rand((array) $business_ids, 1),
        ]);
        $first_user = $users->first();
        $output->writeln('email:'.$first_user->email.' password:password');
    }
}
