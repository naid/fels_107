<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    protected $fillable = ['lesson_id', 'user_id', 'activity', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    public function getAllUserActivities()
    {
        return Activity::where('user_id', Auth::id())->get();
    }
}
