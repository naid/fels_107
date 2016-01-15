<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $guarded = [];

    protected $fillable = ['word', 'meaning', 'sound', 'options', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function lessonWords()
    {
        return $this->hasMany(LessonWord::class, 'word_id');
    }

}
