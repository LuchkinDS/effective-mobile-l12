<?php

use App\Http\Controllers\Api\v1\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('tasks', [TaskController::class, 'index'])->name('api.v1.task.index');
    Route::post('tasks', [TaskController::class, 'store'])->name('api.v1.task.store');
    Route::get('tasks/{task}', [TaskController::class, 'show'])->name('api.v1.tasks.show');
    Route::post('tasks/{id}', [TaskController::class, 'update'])->name('api.v1.tasks.update');
    Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('api.v1.tasks.destroy');
});
