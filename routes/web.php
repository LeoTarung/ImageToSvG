<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageToSvgController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;

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

Route::get('/login', [AuthController::class, 'tampilanLogin'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login/masuk', [AuthController::class, 'Login'])->name('proses_login');
Route::get('/daftar', [AuthController::class, 'tampilanDaftar']);
Route::post('/daftar', [AuthController::class, 'daftar']);
Route::get('forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.update');

Route::get('/', [EmployeeController::class, 'index'])->middleware('auth');
Route::get('/karyawan', [EmployeeController::class, 'indexKaryawan'])->name('indexKaryawan')->middleware('auth');
Route::get('/evaluasi', [EmployeeController::class, 'indexEvaluasi'])->name('indexEvaluasi')->middleware('auth');
Route::post('/uplodfile', [EmployeeController::class, 'uplodFile'])->middleware('auth');
Route::get('/count', [EmployeeController::class, 'count'])->middleware('auth');
Route::get('/form', [EmployeeController::class, 'indexForm'])->middleware('auth');
Route::post('/uplodform', [EmployeeController::class, 'uploadForm'])->middleware('auth');

Route::get('/datakaryawan', [EmployeeController::class, 'dtKaryawan'])->name('dataKaryawan');
Route::get('/datauji', [EmployeeController::class, 'dtUji'])->name('dataUji');
Route::get('/dataHasiluji', [EmployeeController::class, 'dtHasilUji'])->name('dataHasilUji');
Route::post('/settingDataUji', [EmployeeController::class, 'submitDataUji'])->name('submitDataUji');
Route::post('/settingDataLatih', [EmployeeController::class, 'submitDataLatih'])->name('submitDataLatih');
Route::post('/formatKaryawan', [EmployeeController::class, 'formatKaryawan'])->name('formatKaryawan');
Route::get('/hitungUji', [EmployeeController::class, 'hitungUji'])->name('hitungUji');
