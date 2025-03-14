<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public $fillable = ['name', 'sesion_id'];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
