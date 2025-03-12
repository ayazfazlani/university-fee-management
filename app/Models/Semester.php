<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    public $fillable = ['name', 'start_date', 'end_date', 'section_id'];
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
