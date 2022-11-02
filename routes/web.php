<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TarefaController;
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

Route::resource('/', 'App\Http\Controllers\TarefaController');

// Route::get('/', [TarefaController::class, 'index'])->name('home');

// Route::get('/create', [TarefaController::class, 'create'])->name('criar');

// Route::post('/criar', [TarefaController::class, 'store'])->name('criar-tarefa');
