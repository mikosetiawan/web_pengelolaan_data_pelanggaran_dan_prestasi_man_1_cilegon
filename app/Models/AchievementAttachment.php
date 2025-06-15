<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'achievement_id',
        'file_path',
        'file_name',
    ];

    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }
}