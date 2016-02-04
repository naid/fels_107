<?php
namespace App\Http\Controllers;

use App\Activity;
use App\Auth;
use App\Follow;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Redirect;
use Session;

class UserController extends Controller
{

    public function index()
    {
        $title = trans('common.users.page_title');

        $activity = new Activity;

        $activities = $activity->getAllUserActivities($this->user->id);

        $view = ($this->user->isAdmin()) ? 'home' : 'users.home';
        return view($view, [
            'user' => $this->user,
            'activities' => $activities,
            'title' => $title . $this->user->id,
        ]);
    }

    public function activities()
    {
        $title = trans('common.users.page_title');

        $activity = new Activity;

        $activities = $activity->getUserFolloweeActivities($this->user->id);

        $view = ($this->user->isAdmin()) ? 'home' : 'users.view_activities';
        return view($view, [
            'user' => $this->user,
            'activities' => $activities,
            'title' => $title . $this->user->id,
        ]);
    }

    public function edit()
    {
        return view('users.edit', [
            'title' => 'Edit category',
            'user' => $this->user,
        ]);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(intval($this->user->id));
        $validate = [
            'user_name' => 'required|max:255',
            'user_email' => 'required|max:255',
        ];

        $this->validate($request, $validate);
        $user->assign($request);

        return redirect('/home');
    }

    public function changePassword()
    {
        return view('users.change_password', [
            'title' => 'Change Password',
            'user' => $this->user,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = User::findOrFail(intval($this->user->id));

        $validate = [
            'new_password' => 'required|max:255|confirmed',
            'new_password_confirmation' => 'required|max:255',
        ];

        if (!(Hash::check($request->input('user_password'), $user->password))) {
            $validate['user_password'] = 'required|max:255|same:old_password';
        }

        $this->validate($request, $validate);
        $user->updatePassword($request->input('new_password'));
        Session::flash('message', 'Password changed.');

        return redirect('/home');
    }

    public function listUsers()
    {
        $users = User::where('id', '!=', $this->user->id)->get();
        $follows = Follow::where('follower_id', $this->user->id)->lists('followee_id');

        return view('users.list', [
            'usersList' => $users,
            'follows' => $follows->toArray(),
        ]);
    }

    public function followUser($userId)
    {
        $follow = new Follow;
        $follow->addFollowee($this->user->id, $userId);

        return redirect('/users/list');
    }

    public function unFollowUser($userId)
    {
        $follow = new Follow;
        $follow->removeFollowee($this->user->id, $userId);

        return redirect('/users/list');
    }

}
