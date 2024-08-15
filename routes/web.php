<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TodoController::class, 'index'])->name('home');
Route::view('/create','create');


Route::resource('todos', TodoController::class)->except(['index', 'update']);
Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
