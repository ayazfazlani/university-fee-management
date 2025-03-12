<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Session extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_date', 'end_date'];

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}
