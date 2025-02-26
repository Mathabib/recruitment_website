<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';

    protected $fillable = [
        'name_jurusan',
        'education_id', // Ensure this is included
    ];


    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id');
    }
}
