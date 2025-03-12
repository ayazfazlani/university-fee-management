<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'section_id', 'roll_number', 'fee_amount', 'status',  'admission_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function feeRecords()
    {
        return $this->hasMany(FeeRecord::class);
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
