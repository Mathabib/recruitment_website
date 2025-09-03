<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        // return Auth::user();
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function update(Request $request)
{
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = Auth::user();

        $data = [
            'name' => $request->name,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('user_photos', 'public');
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Data Successfully Updated');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Something Went Wrong');
    }
}

}
