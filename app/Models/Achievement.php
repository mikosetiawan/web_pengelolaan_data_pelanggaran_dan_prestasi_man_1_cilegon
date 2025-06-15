<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achievement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'achievement_type_id',
        'title',
        'date',
        'level',
        'award',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function achievementType()
    {
        return $this->belongsTo(AchievementType::class);
    }

    public function attachments()
    {
        return $this->hasMany(AchievementAttachment::class);
    }
}