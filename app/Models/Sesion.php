<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sesion extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'start_date', 'end_date'];

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
