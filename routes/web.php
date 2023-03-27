<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CalendarController;

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
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('calendar/index', [CalendarController::class, 'index'])->name('calendar.index');

Route::get('calendar.store', [CalendarController::class, 'store'])->name('calendar.store');

Route::get('calendar.delete', [CalendarController::class, 'destroy'])->name('calendar.delete');

Route::get('calendar.update', [CalendarController::class, 'edit'])->name('calendar.update');





// Route::get('/calendar', [HomeController::class, 'calendar'])->name('home.calendar');

// Route::get('/', function () {
//     return view('index');
// });
