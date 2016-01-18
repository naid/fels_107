<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded = [];

    protected $fillable = ['category_id', 'user_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lessonWords()
    {
        return $this->hasMany(LessonWord::class, 'lesson_id');
    }

    public function activity()
    {
        return $this->hasOne(Activity::class, 'lesson_id')
    }
}
