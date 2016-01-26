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

    public function edit($id)
    {
        try {
            return view('users.edit', [
                'title' => 'Edit category',
                'user' => $this->user,
            ]);
        }
        catch (ModelNotFoundException $e)
        {
            \Session::flash('flash_error', 'Edit failed. The user cannot be found.');
        }
        return redirect('/home');
    }

    public function create($id)
    {
        try {
            return view('users.edit', [
                'title' => 'Edit category',
                'user' => $this->user,
            ]);
        }
        catch (ModelNotFoundException $e)
        {
            \Session::flash('flash_error', 'Edit failed. The user cannot be found.');
        }
        return redirect('/home');
    }

    public function update(Request $request, $id)
    {
        $user = User::find(intval($id));

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
        try {
            return view('users.change_password', [
                'title' => 'Change Password',
                'user' => $this->user,
            ]);
        }
        catch (ModelNotFoundException $e)
        {
            \Session::flash('flash_error', 'Edit failed. The user cannot be found.');
        }
        return redirect('/homes');
    }

    public function updatePassword(Request $request)
    {
        $user = User::find(intval($this->user->id));

        $validate = [
            'new_password' => 'required|max:255|confirmed',
            'new_password_confirmation' => 'required|max:255',
        ];

        if (Hash::check($request->input('user_password'), $user->password))
        {
            $this->validate($request, $validate);
            $user->updatePassword($request->input('new_password'));
        }
        else
        {
            $validate = [
                'user_password' => 'required|max:255|same:old_password',
            ];
            $this->validate($request, $validate);
        }

        return redirect('/home');
    }

}
