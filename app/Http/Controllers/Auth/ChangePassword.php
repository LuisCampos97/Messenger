<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('auth.changepassword');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        if (!(Hash::check($request->current_password, $user->password))) {
            return back()->with('error', 'Your current password is wrong!');
        }

        if (strcmp($request->current_password, $request->new_password) == 0) {
            return back()->with('error', 'The current password and the new password are the same!');
        }

        if (!strcmp($request->new_password, $request->new_password_confirmation) == 0) {
            return back()->with('error', 'The new password and the new password confirmation dont are the same!');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
        ]);

        $user->password = bcrypt($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed');
    }
}
