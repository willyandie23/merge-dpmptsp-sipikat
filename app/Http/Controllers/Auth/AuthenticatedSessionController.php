<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        // Cek role pakai Spatie Permission
        if ($user->hasAnyRole(['admin', 'superadmin'])) {
            // Admin / Superadmin → ke backend
            return redirect()
                ->intended(route('backend.index'))  // intended biar aman kalau user akses /backend dulu
                ->with('status', 'Selamat datang kembali di Panel Admin, ' . $user->name . '!');
        }

        // User biasa (tanpa role admin) → ke dashboard default atau home
        return redirect()
            ->intended(route('dashboard'))
            ->with('status', 'Selamat datang kembali!');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
