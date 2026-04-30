<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;

// Admin routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::delete('/projects/{project}', [AdminController::class, 'destroyProject'])->name('admin.projects.destroy');
});

Route::get('/', function () {   
    return redirect('/login');
});

Auth::routes();

Route::get('/home', function() {
    return redirect('/dashboard');
})->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Project
    Route::resource('projects', ProjectController::class);
    Route::post('projects/{project}/join', [ProjectController::class, 'join'])->name('projects.join');

    Route::post('projects/{project}/join', [ProjectController::class, 'join'])->name('projects.join');
Route::delete('projects/{project}/members/{user}', [ProjectController::class, 'removeMember'])->name('projects.removeMember');

    // Group
    Route::get('projects/{project}/groups/{group}', [GroupController::class, 'show'])->name('projects.groups.show');
    Route::resource('projects.groups', GroupController::class);

    // Group Members
    Route::post('projects/{project}/groups/{group}/members', [GroupController::class, 'addMember'])->name('groups.addMember');
    Route::delete('projects/{project}/groups/{group}/members/{member}', [GroupController::class, 'removeMember'])->name('groups.removeMember');

    // Task (Kanban)
    Route::resource('groups.tasks', TaskController::class);
    Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    Route::get('projects/{project}/join', [ProjectController::class, 'joinForm'])->name('projects.joinForm');
});