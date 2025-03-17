<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'applicants'; // Optional: specify if your table is not following Laravel's naming conventions

    protected $fillable = [
        'job_id',
        'education_id',
        'jurusan_id',

        'name',
        'address',
        'number',
        'email',
        'profil_linkedin',
        'certificates',
        'experience_period', // Added this field
        'photo_pass',
        'profile',
        'languages',
        'mbti', // Added this field
        'iq', // Added this field
        'achievement', // Added this field
        'skills',
        'salary_expectation',
        'status',
        'type'
    ];

    // Define the relationship with the Job model
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id');
    }

    // Relasi ke tabel jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }


    public function references()
    {
        return $this->hasMany(Reference::class);
    }

    public function languages()
    {
        return $this->hasMany(Language::class);
    }

    public function notes()
    {
        return $this->hasOne(Notes::class);
    }
}
