<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'project';

    protected $fillable = [
        'project_name', 
        'desc_project', 
        'client', 
        'mulai_project', 
        'selesai_project',
        'applicant_id', // Ensure this is included
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}

