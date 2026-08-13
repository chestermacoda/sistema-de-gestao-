<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClienteLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.cliente-login');   // crie esta view
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'telefone' => 'required',
            'password' => 'required',
        ]);

        $result = Auth::guard('cliente')->attempt(
            $credentials,
            $request->filled('remember')
        );

        if ($result) {
            $request->session()->regenerate();
            return redirect()->route('cliente.app.clientes');
        }

        return back()->withErrors([
            'telefone' => 'Credenciais inválidas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('cliente')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('cliente.login');
    }
}
