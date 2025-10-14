<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Applicant;
use App\Models\User;

class UserApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $applicants = Applicant::whereNotNull('email')->get();
        foreach ($applicants as $applicant) {
        $user = User::firstOrCreate(
            ['email' => $applicant->email], // cek berdasarkan email
            [
                'name' => $applicant->name,
                'password' => bcrypt('123123123'),
                'role' => 'applicant'
            ]
        );
        $applicant->update([
            "user_id" => $user->id
        ]);
    }

    }
}
