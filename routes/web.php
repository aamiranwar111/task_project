<?php

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
	if(!auth::user()){
        return redirect()->route('login');
    }
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/tasks', [App\Http\Controllers\HomeController::class, 'task'])->name('tasks');
Route::get('/tasks/create', [App\Http\Controllers\HomeController::class, 'create'])->name('tasks.create');
Route::get('/tasks/edit/{id}', [App\Http\Controllers\HomeController::class, 'edit'])->name('tasks.edit');
Route::post('/tasks/update', [App\Http\Controllers\HomeController::class, 'update'])->name('tasks.update');
Route::post('/tasks/destroy/{id}', [App\Http\Controllers\HomeController::class, 'delete'])->name('tasks.destroy');
Route::post('/tasks/update_sort', [App\Http\Controllers\HomeController::class, 'update_sort'])->name('tasks.update_sort');
