<?php

namespace App;

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
}
