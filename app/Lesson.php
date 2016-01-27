<?php

namespace App;

use App\LessonWord;
use App\Word;
use DB;
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
        return $this->hasOne(Activity::class, 'lesson_id');
    }

    public function generateLessonWords()
    {
        $learnedWords = LessonWord::where('answer', '!=', '')
            ->whereNotNull('answer')
            ->where('user_id', $this->user_id)
            ->lists('word_id');
        $lessonWords = Word::with('lessonWords')
            ->where('category_id', $this->category_id)
            ->whereNotIn('id', $learnedWords)
            ->orderBy(DB::raw('RAND()'))
            ->take(3)
            ->get();
        $lessonWordsToInsert = [];
        foreach ($lessonWords as $lessonWord) {
            $lessonWordsToInsert[] = [
                'lesson_id' => $this->id,
                'word_id' => $lessonWord->id,
                'user_id' => $this->user_id,
            ];
        }
        try {
            $this->LessonWord = new LessonWord;
            $this->LessonWord->insert($lessonWordsToInsert);
            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function setLesson($userId, $categoryId)
    {
        $this->user_id = $userId;
        $this->category_id = $categoryId;
        $this->save();
    }
}
