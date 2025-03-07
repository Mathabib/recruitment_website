<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new ApplicantSheetImport(), 
            1 => new ProjectSheetImport(), 
            2 => new ReferenceSheetImport(), 
            3 => new WorkExperienceSheetImport(),

        ];
    }
}
