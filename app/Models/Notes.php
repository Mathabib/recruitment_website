<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;
    
    protected $table = 'notes'; // Optional: specify if your table is not following Laravel's naming conventions

    protected $fillable = [
        'notes',
        
       
        
    ];

    public function applicant()
{
    return $this->belongsTo(Applicant::class);
}
}
