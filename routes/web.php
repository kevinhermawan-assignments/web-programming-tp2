<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Root route for Projects
Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
Route::post('/', [ProjectController::class, 'store'])->name('projects.store');
Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

// Tasks within a specific project
Route::get('/{project}/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::patch('/{project}/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/{project}/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
