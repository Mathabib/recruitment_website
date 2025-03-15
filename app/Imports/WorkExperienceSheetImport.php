<?php

namespace App\Imports;

use App\Models\Applicant;
use App\Models\WorkExperience;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class WorkExperienceSheetImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        // Cari ID Applicant berdasarkan email (applicant_id dalam Excel)
        $applicant = Applicant::where('email', $row['applicant_id'])->first();

        // Jika Applicant ditemukan, simpan data WorkExperience
        if ($applicant) {
            return new WorkExperience([
                'applicant_id'  => $applicant->id, // Gunakan ID applicant yang sudah ditemukan
                'role'           => $row['role'] ?? null,
                'name_company'   => $row['name_company'] ?? null,
                'desc_kerja'     => $row['desc_kerja'] ?? null,
                'mulai'          => $row['mulai'] ?? null,  // Pastikan formatnya sesuai
                'selesai'        => $row['selesai'] ?? null, // Pastikan formatnya sesuai
            ]);
        }

        // Jika tidak ditemukan applicant, abaikan data ini
        return null;
    }
}
