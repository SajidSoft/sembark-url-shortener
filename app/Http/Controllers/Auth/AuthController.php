<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Services\AuthenticateUserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(AuthRequest $request, AuthenticateUserService $user)
    {
        $user->execute($request->validated());

        return redirect()->intended('/dashboard');
    }

    public function destroy(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
