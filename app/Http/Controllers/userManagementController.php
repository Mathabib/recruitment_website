<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class userManagementController extends Controller
{
    public function index(){
        $users = User::all();
        return view('user_management.index', compact('users'));
    }

    public function edit($id){
        $user = User::findOrFail($id);
        return $user;

    }
}
