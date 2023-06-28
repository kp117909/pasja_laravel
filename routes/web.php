<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\WorkerController;
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

    // Client Profile
    Route::get('client.profile', [ClientController::class, 'profile'])->name('client.profile');

    Route::post('client.update', [ClientController::class, 'update'])->name('profile.update');

    Route::post('client.notify', [ClientController::class, 'notify'])->name('client.notify');

    Route::get('worker.rate/{id}/{n_id}', [ClientController::class, 'rate'])->name('worker.rate');

    Route::post('rate.store', [ClientController::class, 'createRate'])->name('rate.store');

    // Worker Profile
    Route::get('worker.profile', [WorkerController::class, 'profile'])->name('worker.profile');

    Route::post('worker.update', [WorkerController::class, 'update'])->name('profile-worker.update');
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

    //Workers
    Route::get('worker.saveAvailability', [WorkerController::class, 'saveAvailability'])->name('worker.saveAvailability');

    Route::get('worker.cardProfile/{id}', [WorkerController::class, 'cardProfile'])->name('worker.cardProfile');

    Route::get('add.notify', [Controller::class, 'notifyAdd'])->name('add.notify');

//    Route::post('calendar.status', [CalendarController::class, 'status'])->name('calendar.status');

    Route::get('/calendar.events', [CalendarController::class, 'getEvents']);
    //end Calendar

    });



// Route::get('/calendar', [HomeController::class, 'calendar'])->name('home.calendar');

 Route::get('/', function () {
     return view('auth.login');
 });
