<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApplicantRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register_applicant');
    }

    public function register(Request $request)
    {

       $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
            // 'address'  => 'nullable|string|max:255',
       ]);

        // 1️⃣ Buat user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'applicant', // tambahkan kolom role di users jika belum
        ]);

        // 2️⃣ Buat applicant terkait
        Applicant::create([
            'user_id' => $user->id,
            'name'   => $request->name,
            'number'   => $request->phone,
            'email' => $request->email,
            'address' => $request->address
        ]);

        // 3️⃣ Login otomatis
        Auth::login($user);

        // 4️⃣ Redirect ke halaman applicant
        return redirect()->route('applicant_page.profile');
    }
}
