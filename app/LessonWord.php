<?php

namespace App;

use App\Word;
use Illuminate\Database\Eloquent\Model;

class LessonWord extends Model
{
    const RESULT_CORRECT = 1;
    const RESULT_WRONG = 0;

    protected $table = 'lesson_word';
    protected $guarded = [];

    protected $fillable = ['answer', 'result', 'word_id', 'user_id', 'lesson_id'];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    public function setAnswer($request)
    {
        $this->result = LessonWord::RESULT_WRONG;
        if ($request->input('answer') == $this->word->meaning) {
            $this->result = LessonWord::RESULT_CORRECT;
        }
        $this->answer = $request->input('answer');
        $this->save();
    }
}
