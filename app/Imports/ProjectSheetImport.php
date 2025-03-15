<?php

namespace App\Imports;

use App\Models\Project;
use App\Models\Applicant;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use Maatwebsite\Excel\Concerns\ToModel;

class ProjectSheetImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        // Cari ID Applicant berdasarkan email 
        $applicant = Applicant::where('email', $row['applicant_id'])->first();

        if ($applicant) {
            return new Project([
                'applicant_id'  => $applicant->id,
                'project_name'  => $row['project_name'] ?? null,
                'desc_project'  => $row['desc_project'] ?? null,
                'client'        => $row['client'] ?? null,
                'mulai_project' => $row['mulai_project'] ?? null,
                'selesai_project' => $row['selesai_project'] ?? null,
            ]);
        }

        return null; 
    }
}
