<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicesController;
use Illuminate\Support\Facades\Route;

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

//Registration and login

Route::get('login', [AuthController::class, 'index'])->name('login');

Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');

Route::get('registration', [AuthController::class, 'registration'])->name('registration');

Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');

// end Registration and login

Route::group(['middleware' => ['auth']], function () {

//    Route::group([
//        'prefix' =>'admin',
//        'middleware'=>'is_admin',
//        'as'=>'admin.',
//    ],function (){
//        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
//    });
//
//    Route::group([
//        'prefix' =>'user',
//        'as'=>'user.',
//    ],function (){
//        Route::get('profile', [\App\Http\Controllers\User\ProfileController::class, 'index'])->name('profile.index');
//    });

    // Client Profile
    Route::get('client.profile', [ClientController::class, 'profile'])->name('client.profile');

    Route::post('client.update', [ClientController::class, 'update'])->name('profile.update');
    // end Client Profile

    // Basic Pages
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('index', [HomeController::class, 'index'])->name('home.index');

    Route::get('info', [HomeController::class, 'info'])->name('home.info');
    //end Basic Pages

    // Services components
    Route::get('services.destroy', [ServicesController::class, 'destroy'])->name('services.destroy');

    Route::post('services.store', [ServicesController::class, 'store'])->name('services.store');

    Route::post('services.update', [ServicesController::class, 'update'])->name('services.update');

    //end Services components

    //Calendar
    Route::get('calendar/index', [CalendarController::class, 'index'])->name('calendar.index');

    Route::get('calendar.store', [CalendarController::class, 'store'])->name('calendar.store');

    Route::get('calendar.delete', [CalendarController::class, 'destroy'])->name('calendar.delete');

    Route::get('calendar.update', [CalendarController::class, 'update'])->name('calendar.update');

    Route::get('calendar.edit', [CalendarController::class, 'edit'])->name('calendar.edit');
    //end Calendar

});



// Route::get('/calendar', [HomeController::class, 'calendar'])->name('home.calendar');

 Route::get('/', function () {
     return view('auth.login');
 });
