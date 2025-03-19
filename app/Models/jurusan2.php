<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jurusan2 extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
    public function educations()
    {
        return $this->belongsTo(Education::class);
    }
}
