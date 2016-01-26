<?php

namespace App;

use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    const ROLE_ADMIN = 'admin';

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password', 'avatar'];

    protected $hidden = ['password', 'remember_token'];

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'user_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'user_id');
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function followees()
    {
        return $this->hasMany(Follow::class, 'followee_id');
    }

    public function isAdmin()
    {
        return ($this->type == User::ROLE_ADMIN);
    }

    public function assign($values)
    {
        if (!is_null($values->input('user_id'))) {
            $this->id = $values->input('user_id');
        }

        $path = config()->get('paths.user_path');
        $this->name = $values->input('user_name');
        $this->email = $values->input('user_email');

        if (!empty($values->file('user_avatar'))) {
            $imageName = uniqid() . '.' . $values->file('user_avatar')->getClientOriginalExtension();
            $this->avatar = $imageName;
            $values->file('user_avatar')->move($path, $imageName);
        }
        $this->save();
    }

    public function updatePassword($password)
    {
        $user = User::findOrFail($this->id);
        $user->fill([
            'password' => Hash::make($password),
        ])->save();
    }
}
