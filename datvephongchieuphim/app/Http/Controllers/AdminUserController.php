<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
//        $roles = $this->role->all();
//        return view('admin.users.add', compact('roles'));
        dd('Create');
    }
}
