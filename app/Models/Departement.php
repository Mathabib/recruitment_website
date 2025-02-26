<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;

   
    protected $table = 'departements';

   
    protected $fillable = ['dep_name'];


    public function jobs()
    {
        return $this->hasMany(Job::class, 'department'); 
    }
   
}


