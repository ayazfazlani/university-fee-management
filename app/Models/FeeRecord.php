<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeRecord extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'semester_id', 'class_id', 'section_id', 'total_fee', 'paid_amount', 'status'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
