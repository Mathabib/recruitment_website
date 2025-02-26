<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    
    protected $table = 'jobs';
    protected $fillable = [
        'job_name',
        'work_location_id', 
        'spesifikasi',     
        'department',
        'employment_type',
        'minimum_salary',
        'maximum_salary',
        'benefit',
        'responsibilities',
        'requirements',
        'status_published',
    ];

   
    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }

    // Relasi ke departemen
    public function departement()
    {
        return $this->belongsTo(Departement::class, 'department');
    }

    // Relasi ke lokasi kerja
    public function workLocation()
    {
        return $this->belongsTo(WorkLocation::class, 'work_location_id');
    }
}
