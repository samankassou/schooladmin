<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::group([
    'middleware' => 'auth',
    'as' => 'admin.',
    'prefix' => 'admin'
], function(){
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('students', StudentController::class);
    Route::post('users/toggleStatus/{user}', [UserController::class, 'toggleStatus']);
});
