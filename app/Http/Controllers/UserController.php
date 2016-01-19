<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Redirect;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $title = trans('common.users.page_title');
        $user = \Auth::user();
        return view('home', compact('title', 'user'));
    }
}
