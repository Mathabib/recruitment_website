<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $table = 'work_experience'; // Optional: specify if your table is not following Laravel's naming conventions

    protected $fillable = [
        'name_company',
        'role',
        'desc_kerja',
        'mulai',
        'selesai',
        
    ];

    public function applicant()
{
    return $this->belongsTo(Applicant::class);
}

}
