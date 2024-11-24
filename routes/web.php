<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\BookController;
use App\Models\Book;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Http\Controllers\SendEmailController;

Route::get('/send-mail', [SendEmailController::class,
'index'])->name('kirim-email');
Route::post('/post-email', [SendEmailController::class, 'store'])->name('post-email');

Route::get('/', function () {
    return view('welcome');
});

Route::resource('book', BookController::class);
Route::get('/users', [LoginRegisterController::class, 'users'])->name('users')->middleware('auth');
Route::post('/user/update-photo', [LoginRegisterController::class, 'updatePhoto'])->name('update.photo');


Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});

use App\Http\Controllers\GalleryController;
Route::resource('gallery', GalleryController::class);

Route::get('/product', [BookController::class, 'api'])->name('book.index');
