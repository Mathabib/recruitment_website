<?php

namespace App\Imports;

use App\Models\Applicant;
use App\Models\Education;
use App\Models\Job;
use App\Models\Jurusan; // Menambahkan model Jurusan
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ApplicantSheetImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        $education_description = $row['education_id']; 
        $education_id = explode(' ', $education_description)[0];  
        $education_id = (int)$education_id;
        $education = Education::find($education_id);

        $job_description = $row['job_id']; 
        $job_id = explode(' ', $job_description)[0];  // memisahkan ID dari deskripsi
        $job_id = (int)$job_id;
        $job = Job::find($job_id);

        if (!$education || !$job) {
            return null; 
        }

        $jurusan_id = $row['jurusan_id'] ?? null;
        $jurusan_name = null;

        if (is_string($jurusan_id)) {
            $jurusan = Jurusan::firstOrCreate(
                ['name_jurusan' => $jurusan_id], 
                ['education_id' => $education_id] 
            );
            $jurusan_id = $jurusan->id; 
            $jurusan_name = $jurusan->name_jurusan; 
        }

        return new Applicant([
            'jurusan_id'         => $jurusan_id,   
            'education_id'       => $education_id,  
            'job_id'             => $job_id,
            'name'               => $row['name'] ?? null,
            'address'            => $row['address'] ?? null,
            'number'             => $row['number'] ?? null,
            'email'              => $row['email'] ?? null,
            'profil_linkedin'    => $row['profil_linkedin'] ?? null,
            'certificates'       => $row['certificates'] ?? null,
            'experience_period'  => $row['experience_period'] ?? null,
            'photo_pass'         => $row['photo_pass'] ?? 'default_photo.jpg',
            'profile'            => $row['profile'] ?? null,
            'languages'          => $row['languages'] ?? null,
            'mbti'               => $row['mbti'] ?? null,
            'iq'                 => $row['iq'] ?? null,
            'achievement'        => $row['achievement'] ?? null,
            'skills'             => $row['skills'] ?? '',
            'salary_expectation' => $row['salary_expectation'] ?? null,
            'status'             => $row['status'] ?? 'applied',
        ]);
    }
}
