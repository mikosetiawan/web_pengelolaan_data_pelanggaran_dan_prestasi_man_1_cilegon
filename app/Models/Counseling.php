<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counseling extends Model
{
    use HasFactory;

    protected $table = 'counselings';

    protected $fillable = [
        'student_id',
        'violation_id',
        'solution',
        'counseling_date',
        'counselor_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function violation()
    {
        return $this->belongsTo(Violation::class, 'violation_id');
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }
}