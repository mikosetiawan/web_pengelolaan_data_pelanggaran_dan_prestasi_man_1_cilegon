<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;

    protected $table = 'violations';
    
    protected $fillable = [
        'nama_pelanggaran',
        'skor',
        'kategori', // ringan, sedang, berat
    ];

    // Validasi skor antara 5-100
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->skor < 5 || $model->skor > 100) {
                throw new \Exception('Skor harus antara 5 dan 100');
            }
        });
    }

    // Relasi ke Pelanggaran
    public function pelanggarans()
    {
        return $this->hasMany(Pelanggaran::class, 'violation_id');
    }
}