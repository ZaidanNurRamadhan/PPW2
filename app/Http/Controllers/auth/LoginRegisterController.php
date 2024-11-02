<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Assuming you are using the User model
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendMailJob;

class LoginRegisterController extends Controller
{
    /*
    * Instantiate a new LoginRegisterController instance.
    */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'dashboard']);
    }


    /**
    * Display a registration form.
    *
    * @return \Illuminate\Http\Response
    */
    public function register()
    {
        return view('auth.register');
    }

    /**
    * Store a newly registered user.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
{
    // Validasi data
    $request->validate([
        'name' => 'required|string|max:250',
        'email' => 'required|email|max:250|unique:users',
        'password' => 'required|min:8|confirmed',
    ]);

    // Buat pengguna baru
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'email_verified_at' => now()
    ]);

    // Login pengguna setelah registrasi
    Auth::attempt($request->only('email', 'password'));

    // Regenerasi session dan token CSRF
    $request->session()->regenerate();

    // Dispatch email job (Jika perlu)
    $emailData = [
        'email' => $user->email,
        'name' => $user->name,
        'subject' => 'Selamat Datang di Platform Kami!',
        'message' => 'Halo ' . $user->name . ', terima kasih telah mendaftar di platform kami.'
    ];
    dispatch(new SendMailJob($emailData));

    // Redirect ke halaman tujuan dengan pesan sukses
    return redirect('/book')->with('login', 'Anda telah berhasil mendaftar & masuk!');
}


    /**
    * Display a login form.
    *
    * @return \Illuminate\Http\Response
    */
    public function login()
    {
        return view('auth.login');
    }

    /**
    * Authenticate the user.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function authenticate(Request $request)
    {
        // Validate the request data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            // Regenerate session
            $request->session()->regenerate();

            // Redirect to dashboard with success message
            return redirect('/book')->with('login', 'You have successfully logged in!');
        }

        // If authentication fails, return error
        return back()->withErrors([
            'email' => 'Your provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
    * Display the dashboard to authenticated users.
    *
    * @return \Illuminate\Http\Response
    */
    // public function dashboard()
    // {
    //     if (Auth::check()) {
    //         return redirect()->route('dashboard')->with('login', 'You have successfully logged in!');
    //     }

    //     return redirect()->route('dashboard')
    //         ->withErrors([
    //             'email' => 'Please login to access the dashboard.',
    //         ])->onlyInput('email');
    // }

    /**
    * Log out the user from the application.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate session token
        $request->session()->regenerateToken();

        // Redirect to login with success message
        return redirect('/book')->with('logout', 'You have successfully logged out!');;
    }
}
