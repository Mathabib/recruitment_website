<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferLetter extends Model
{
    use HasFactory;
     protected $fillable = [
        'applicant_id',
        'job_id',
        'letter_number',
        'offer_date',
        'join_date',
        'basic_salary',
        'allowance',
        'total_salary',
        'notes',
        'contract_duration',
        'responsibility_allowance'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
