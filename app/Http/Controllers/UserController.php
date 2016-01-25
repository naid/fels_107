<?php
namespace App\Http\Controllers;

use App\Activity;
use App\Auth;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Redirect;

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
}
