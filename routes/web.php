<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', [AuthController::class, 'index'])->name('login');

Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');

Route::get('registration', [AuthController::class, 'registration'])->name('registration');

Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');

Route::group(['middleware' => ['auth']], function () {

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('index', [HomeController::class, 'index'])->name('home.index');

    Route::get('profil', [HomeController::class, 'profil'])->name('home.profil');

    Route::get('info', [HomeController::class, 'info'])->name('home.info');

    Route::get('calendar/index', [CalendarController::class, 'index'])->name('calendar.index');

    Route::get('calendar.store', [CalendarController::class, 'store'])->name('calendar.store');

    Route::get('calendar.delete', [CalendarController::class, 'destroy'])->name('calendar.delete');

    Route::get('calendar.update', [CalendarController::class, 'update'])->name('calendar.update');

    Route::get('calendar.edit', [CalendarController::class, 'edit'])->name('calendar.edit');

    Route::post('update_photo', [ClientController::class, 'update'])->name('client.update');

});



// Route::get('/calendar', [HomeController::class, 'calendar'])->name('home.calendar');

 Route::get('/', function () {
     return view('auth.login');
 });
