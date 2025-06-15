<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'grades';

    protected $fillable = [
        'student_id',
        'user_id',
        'major', // Jurusan contoh: IPA, IPS
        'academic_year',
        'semester',
        'average_grade', // nilai rata-rata contoh: 85.5
    ];

    protected $casts = [
        'average_grade' => 'float', // Changed from 'array' to 'float'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
