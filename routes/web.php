<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CycleController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ClassroomController;

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
    Route::resource('cycles', CycleController::class);
    Route::resource('levels', LevelController::class);
    Route::post('teachers/{teacher}/toggleTeacherStatus', [TeacherController::class, 'toggleTeacherStatus']);
    Route::resource('roles', RoleController::class);
    Route::resource('classrooms', ClassroomController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('courses', CourseController::class);
    Route::post('users/{user}/toggleUserStatus', [UserController::class, 'toggleUserStatus']);
});
