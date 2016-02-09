<?php
namespace App\Http\Controllers;

use App\Activity;
use App\Auth;
use App\Events\ActivityEvent;
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
    public function __construct()
    {
        parent::__construct();
    }

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

    public function listUsers(Request $request)
    {
        $users = User::where('id', '!=', $this->user->id)->get();
        $follows = Follow::where('follower_id', $this->user->id)->lists('followee_id');

        return view('users.list', [
            'usersList' => $users,
            'status' => Follow::STATUS_ALL,
            'follows' => $follows->toArray(),
        ]);
    }

    public function filterUsers(Request $request)
    {

        $follow = new Follow;
        $followeeIds = $follow->getFollowedByUser($this->user->id);

        $users = new User;

        switch ($request->input('status')) {
            case 'followed':
                $users = $users->whereIn('id', $followeeIds);
                break;
            case 'notfollowed':
                $users = $users->whereNotIn('id', $followeeIds);
                break;
            default:
                break;
        }

        $useInput = $request->input('user');

        $users = $users->where(

            function ($q) use ($useInput) {
                return $q->where('name', 'LIKE', "%$useInput%")
                    ->orWhere('email', 'LIKE', "%$useInput%")->get();
            }

        )->get();

        $follows = Follow::where('follower_id', $this->user->id)->lists('followee_id');

        return view('users.list', [
            'usersList' => $users,
            'status' => $request->input('status'),
            'follows' => $follows->toArray(),
        ]);
    }

    public function followUser($userId)
    {
        $followee = User::findorFail(intval($userId));
        $follow = new Follow;
        $follow->addFollowee($this->user->id, $followee->id);

        $eventData = [
            'userId' => $this->user->id,
            'activity' => $this->user->name . " followed " . $followee->name,
            'lessonId' => User::NO_LESSONID,
            'type' => User::FOLLOW_ACTIVITY,
        ];
        \Event::fire(new ActivityEvent($eventData));

        return redirect('/users/list');
    }

    public function unFollowUser($userId)
    {
        $followee = User::findorFail(intval($userId));
        $follow = new Follow;
        $follow->removeFollowee($this->user->id, $followee->id);

        $eventData = [
            'userId' => $this->user->id,
            'activity' => $this->user->name . " unfollowed " . $followee->name,
            'lessonId' => User::NO_LESSONID,
            'type' => User::FOLLOW_ACTIVITY,
        ];
        \Event::fire(new ActivityEvent($eventData));

        return redirect('/users/list');
    }

}
