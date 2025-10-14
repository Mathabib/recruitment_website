<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Applicant;
use Illuminate\Support\Facades\DB;

class pivot_applicant_job_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::statement("
            INSERT INTO applicant_job (applicant_id, job_id, created_at, updated_at)
            SELECT id, job_id, NOW(), NOW()
            FROM applicants
            WHERE job_id IS NOT NULL
        ");
    }
}
