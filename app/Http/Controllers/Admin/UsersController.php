<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\User;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function usersList($id =null){
        $all_users = User::paginate(10);
        $user_type  = Auth::user()->title;
        return view('admin.users.users-list',compact('all_users','user_type'));
    }

    public function userView($id){
        $user = User::find($id);
        $user_type  = Auth::user()->title;
        return view('admin.users.user-view',compact('user', 'user_type'));
    }
}
