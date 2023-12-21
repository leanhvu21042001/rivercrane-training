<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginPostRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('product.index');
        }

        return view('admin.pages.login');
    }

    public function doLogin(LoginPostRequest $request): RedirectResponse
    {

        $credentials = $request->validated();
        $email = $credentials['email'];
        $password = $credentials['password'];
        $remember = $request->input('remember');

        $userFound = User::where('email', '=', $email)->first();
        if (!$userFound) {
            return back()->withErrors([
                'email' => 'Email không chính xác.',
            ])->withInput($request->input());
        }

        if (
            Auth::attempt(['email' => $email, 'password' => $password, 'is_active' => 1], $remember)
        ) {
            $userFound->last_login_at = Carbon::now();
            $userFound->last_login_ip = $request->ip();
            $userFound->save();

            $request->session()->regenerate();
            return redirect()->route('product.index');
        }

        return back()->withErrors([
            'password' => 'Mật khẩu không chính xác.',
        ])->withInput($request->input());
    }
}
