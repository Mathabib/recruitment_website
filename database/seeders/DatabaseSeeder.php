<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Education;
use Illuminate\Database\Seeder;
use \App\Models\WorkLocation;
use \App\Models\Jurusan;
use \App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $worklocations = [
            'On Site', 'Remote', 'Hybrid', 'Client', 'Company', 'Work From Office', 'Overseas', 'Indonesia', 'Jakarta', 'Bekasi Office'
        ];

        foreach($worklocations as $worklocation)
        WorkLocation::create([
           'location' => $worklocation
        ]);
       
        $educations = [
            'SMA', 'SMK','D3', 'S1','S2','S3'
        ];
        foreach($educations as $education) {
            Education::create([
                'name_education' => $education
            ]);
           
        }

        // $sma = ['IPA', 'IPS'];
        // $smk = ['Perkantoran', 'Sistem Informasi Jaringan', 'Accountant'];
        // $s1 = ['Accountant', 'Tehnik Sipil', 'Tehnik Geologi', 'Tehnik Kimia'];

        // foreach($sma as $jurusan) {
        //     jurusan::create([
        //         'name_jurusan' => $jurusan,
        //         'education_id' => '1'
        //     ]);
        // }

        // foreach($smk as $jurusan) {
        //     jurusan::create([
        //         'name_jurusan' => $jurusan,
        //         'education_id' => '2'
        //     ]);
        // }

        // foreach($s1 as $jurusan) {
        //     jurusan::create([
        //         'name_jurusan' => $jurusan,
        //         'education_id' => '4'
        //     ]);
        // }
       

    }
}
