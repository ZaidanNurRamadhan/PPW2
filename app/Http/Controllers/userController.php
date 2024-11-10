<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendMailJob;
use App\Models\Book;
use App\Models\User;

class userController extends Controller
{
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
