<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

require __DIR__ . '/auth.php';

Route::resource('task_statuses', TaskStatusController::class)->except(['show']);

Route::resource('tasks', TaskController::class);

Route::resource('labels', LabelController::class)->except(['show']);
