<?php
namespace App\Http\Controllers;

use App\Activity;
use App\Auth;
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

        $activities = $activity->getAllUserActivities();

        $view = ($this->user->isAdmin()) ? 'home' : 'users.home';
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
        //note to Tung: This is the problem I consulted with you before.
        //I made it in such a way that the old password message and the new passwords mismatch message will
        //be displayed to the User and also to avoid using emails for now to make it simple :)
        //I guess I need your advice on what to do with this or if this is acceptable enough.
        //I will remove this comment on the next pull. Thank you very much Tung :-)
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

}
