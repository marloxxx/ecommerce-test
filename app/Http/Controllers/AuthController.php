<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login()
    {
        return view('pages.frontend.auth.login');
    }

    public function register()
    {
        return view('pages.frontend.auth.register');
    }

    public function forgot()
    {
        return view('pages.frontend.auth.forgot');
    }

    public function do_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            if (auth()->user()->hasRole('admin')) {
                return redirect()->route('backend.dashboard');
            } else {
                return redirect()->route('home');
            }
        } else {
        }
    }

    public function do_register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'nullable|min:3',
            'email' => 'required|email|regex:/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/|unique:users',
            'phone' => 'required|numeric|digits_between:10,13',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name ?? '',
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);
        $user->save();
        $user->assignRole('customer');

        auth()->login($user);
    }

    public function do_forgot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:dns|exists:users,email',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => 'error',
                'message' => $errors->first(),
            ]);
        }
        $status = Password::sendResetLink(
            $request->only('email')
        );
        if ($status === Password::RESET_LINK_SENT) {
        } else {
        }
    }

    public function reset($token, Request $request)
    {
        $email = $request->email;
        return view('pages.frontend.auth.reset', compact('token', 'email'));
    }

    public function do_reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email:dns|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'toc' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => 'error',
                'message' => $errors->first(),
            ]);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'confirm_password', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
        } else {
        }
    }

    public function do_logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
