<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;

class job_default_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Job::create([
           'job_name' => 'default',
            'work_location_id' => '4', // Validate that work_location_id exists
            'department' => '2',
            'employment_type' => 'contract',
            'minimum_salary' => '100000000',
            'maximum_salary' => '50000000',
            'benefit' => 'default',
            'responsibilities' => 'default',
            'requirements' => 'default',
            'spesifikasi' => 'default',
        ]);
    }
}
