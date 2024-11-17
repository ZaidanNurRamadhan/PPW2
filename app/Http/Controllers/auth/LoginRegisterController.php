<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendMailJob;
use App\Models\Book;
use App\Models\User;

class LoginRegisterController extends Controller
{
    /*
    * Instantiate a new LoginRegisterController instance.
    */
    public function __construct()
    {
        $this->middleware('guest')->only(['login', 'register','store']);
        $this->middleware('auth.custom')->only(['logout','dashboard','users','updatePhoto']);
    }


    public function dashboard(){
        $jumlahBuku = Book::count();
        $totalPrice = Book::sum('price');
        $data_book = Book::all();
        return view('buku.index', compact('data_book', 'jumlahBuku', 'totalPrice'));
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
        'photo' => 'nullable|image|max:1999',  // Photo is nullable
    ]);

    // Initialize the photo path
    $photoPath = null;

    // Check if a photo was uploaded
    if ($request->hasFile('photo')) {
        $filenameWithExt = $request->file('photo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('photo')->getClientOriginalExtension();
        $filenameSimpan = $filename . '_' . time() . '.' . $extension;
        $photoPath = $request->file('photo')->storeAs('photos', $filenameSimpan);
    }

    // Buat pengguna baru
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'photo' => $photoPath, // Store the photo path or null
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
            return redirect()->route('dashboard')->with('login', 'You have successfully logged in!');
        }

        // If authentication fails, return error
        return back()->withErrors([
            'email' => 'Your provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
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

    public function users(){
        $user = Auth::user();
        return view('buku.users',compact('user'));
    }

    public function updatePhoto(Request $request)
{
    $request->validate([
        'photo' => 'nullable|image|max:1999',
    ]);

    $user = Auth::user();

    if ($request->hasFile('photo')) {
        $filenameWithExt = $request->file('photo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('photo')->getClientOriginalExtension();
        $filenameSimpan = $filename . '_' . time() . '.' . $extension;
        $path = $request->file('photo')->storeAs('photos', $filenameSimpan);

        $user->update(['photo' => $path]);
    }

    return redirect()->route('users')->with('success', 'Foto berhasil diperbarui!');
}

}
