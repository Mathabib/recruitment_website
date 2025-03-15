<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    protected $table = 'reference'; // Optional: specify if your table is not following Laravel's naming conventions

    protected $fillable = [
     'applicant_id', // Ensure this is included
        'name_ref',
        'phone',
        'email_ref',
       
        
    ];

    public function applicant()
{
    return $this->belongsTo(Applicant::class);
}
}
