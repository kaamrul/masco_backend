<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;

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

Route::name('public.')->as('public.')->namespace('App\Http\Controllers\Public')->group(function () {

    Route::get('/verify-email/{member}/{type}', [HomeController::class, 'verifyEmail'])->name('verify.email');
    Route::post('/verify-email/{member}/{type}', [HomeController::class, 'storeVerifyEmail'])->name('store.verify.email');

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/attendance', [HomeController::class, 'attendance'])->name('sign.in');
    Route::get('/attendance/{employee}', [HomeController::class, 'show']);

    Route::post('/visitor-sign-in', [HomeController::class, 'visitorSignIn'])->name('visitor.sign.in');
    Route::post('/visitor-sign-out', [HomeController::class, 'visitorSignOut'])->name('visitor.sign.out');
    Route::post('/employee-attendance', [HomeController::class, 'EmployeeAttendance'])->name('employee.attendance');
});
