<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Provider;
use App\Models\Agent;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check Admin
        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return redirect()->route('admin.dashboard');
        }

        // Check Provider
        if (Auth::guard('provider')->attempt($request->only('email', 'password'))) {
            return redirect()->route('provider.dashboard');
        }

        // Check Agent
        if (Auth::guard('agent')->attempt($request->only('email', 'password'))) {
            return redirect()->route('agent.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email|unique:agents,email|unique:providers,email',
            'password' => 'required|string|min:6',
            'user_type' => 'required|in:agent,provider,admin',
        ]);

        $user = null;
        switch ($request->user_type) {
            case 'agent':
                $user = Agent::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;

            case 'provider':
                $user = Provider::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;

            case 'admin':
                $user = Admin::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                break;
        }

        return response()->json([
            'message' => 'تم تسجيل الحساب بنجاح!',
            'user' => $user,
        ], 201);
    }


    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('provider')->check()) {
            Auth::guard('provider')->logout();
        } elseif (Auth::guard('agent')->check()) {
            Auth::guard('agent')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

