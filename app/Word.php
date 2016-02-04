<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    const TITLE = 'Words';
    const STATUS_LEARNED = 'learned';
    const STATUS_UNLEARNED = 'unlearned';
    const STATUS_ALL = 'all';
    const NUMBER_WORDS = 10;

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

    public function getSoundAttribute($values)
    {
        return (!empty($values)) ? $values : null;
    }

    public function assign($values)
    {
        if (!is_null($values->input('word_id'))) {
            $this->id = $values->input('word_id');
        }

        $path = config()->get('paths.word_path');
        $this->category_id = $values->input('category');
        $this->word = $values->input('word');
        $this->meaning = $values->input('meaning');
        $this->options = $values->input('option1') . ';' . $values->input('option2') . ';' . $values->input('option3');

        if (!empty($values->file('sound'))) {
            $soundName = uniqid() . '.' . $values->file('sound')->getClientOriginalExtension();
            $this->sound = $soundName;
            $values->file('sound')->move($path, $soundName);
        }
        $this->save();
    }
}
