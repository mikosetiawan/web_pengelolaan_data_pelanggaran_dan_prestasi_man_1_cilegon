<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'spos';

    protected $fillable = [
        'student_id',
        'pelanggaran_id',
        'user_id',
        'sign_id_waka_siswa',
        'sign_id_wali_kelas',
        'sign_id_kepala_sekolah',
        'number_spo',
        'date_spo',
        'time_spo',
        'level_spo', // 1. ringan 25 > 50 skor pelanggaran siswa (level spo : spo_1), 2. sedang 50 > 75 skor pelanggaran siswa (spo_2),  3. berat 75 > 100 skor siswa (spo_3);
    ];

    /**
     * Get the student that owns the SPO.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Get the pelanggaran that owns the SPO.
     */
    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'pelanggaran_id');
    }

    /**
     * Get the user that created the SPO.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user who signed as Wakil Kepala Siswa.
     */
    public function wakaSiswa()
    {
        return $this->belongsTo(User::class, 'sign_id_waka_siswa');
    }

    /**
     * Get the user who signed as Wali Kelas.
     */
    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'sign_id_wali_kelas');
    }

    /**
     * Get the user who signed as Kepala Sekolah.
     */
    public function kepalaSekolah()
    {
        return $this->belongsTo(User::class, 'sign_id_kepala_sekolah');
    }
}