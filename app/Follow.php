<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $guarded = [];

    protected $fillable = ['follower_id', 'followee_id'];

    public function followees()
    {
        return $this->hasMany(User::class, 'followee_id');
    }

    public function followers()
    {
        return $this->hasMany(User::class, 'follower_id');
    }

    public function addFollowee($userId, $followeeId)
    {
        $this->follower_id = $userId;
        $this->followee_id = $followeeId;
        $this->save();
    }

    public function removeFollowee($userId, $followeeId)
    {
        $followEntry = Follow::where('followee_id', $followeeId)->where('follower_id', $userId);
        $followEntry->delete();
    }
}
