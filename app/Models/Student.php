<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = [
        'nis',
        'name',
        'class',
        'gender',
        'phone',
        'address',
        'status', // Status: active, inactive
        'father_name',
        'father_occupation',
        'father_phone',
        'father_address',
        'mother_name',
        'mother_occupation',
        'mother_phone',
        'mother_address',
        'guardian_name',
        'guardian_occupation',
        'guardian_phone',
        'guardian_address',
    ];

    public function pelanggarans()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}