<?php


namespace App\Imports;

use App\Models\Reference;
use App\Models\Applicant;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class ReferenceSheetImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|nullr
    */
    public function model(array $row)
    {
        // dd($row);
        // Pastikan kolom 'applicant_id' di Excel berisi email, bukan ID
        $applicant = Applicant::where('email', $row['applicant_id'])->first(); // Pastikan ini adalah email, bukan ID

        if ($applicant) {
            return new Reference([
                'applicant_id'  => $applicant->id,
                'name_ref'       => $row['name_ref'] ?? null,
                'phone'          => $row['phone'] ?? null,
                'email_ref'      => $row['email_ref'] ?? null,
            ]);
        }

        return null; 
    }
}
