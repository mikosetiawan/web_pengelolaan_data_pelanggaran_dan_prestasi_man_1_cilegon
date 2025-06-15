<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggarans';
    protected $fillable = [
        'student_id',
        'violation_id',
        'points',
        'description',
        'sanksi',
        'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function violation()
    {
        return $this->belongsTo(Violation::class, 'violation_id');
    }
}