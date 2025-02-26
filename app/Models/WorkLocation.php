<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkLocation extends Model
{
    use HasFactory;

    // Define the table if the model name doesn't follow Laravel's naming convention
    protected $table = 'work_location';

    // Define which fields are mass-assignable
    protected $fillable = ['location'];

    // If you have a relationship with jobs, you can define it like this
    public function jobs()
    {
        return $this->hasMany(Job::class, 'work_location_id', 'id');
    }
}
