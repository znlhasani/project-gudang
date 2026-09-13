<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogActivity;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect path after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/Mainpage';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle after user authenticated.
     */
    protected function authenticated(Request $request, $user): void
    {
        LogActivity::create([
            'Aktivitas' => 'Login',
            'Detail'    => 'Login Berhasil',
            'Waktu'     => now(),
            'user'      => $user->name,
            'activity'  => 'Login Berhasil',
            'module'    => 'Authentication',
            'ip'        => $request->ip(),
            'time'      => now(),
            'Id_User'   => $user->id,
        ]);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        LogActivity::create([
            'Aktivitas' => 'Logout',
            'Detail'    => 'Logout Berhasil',
            'Waktu'     => now(),
            'user'      => Auth::user()->name,
            'activity'  => 'Logout Berhasil',
            'module'    => 'Authentication',
            'ip'        => $request->ip(),
            'time'      => now(),
            'Id_User'   => Auth::user()->id,
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
