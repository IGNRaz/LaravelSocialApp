<?php

use App\Http\Controllers\FollowerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

Route::get('/user/{user}', [ProfileController::class, 'showProfile'])->name('UserProfile');

Route::get('/dashboard', function () {
    return view('dashboard', ['tasks' => Task::latest()->simplePaginate(20)]
  );

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/userprofile', [ProfileController::class,'ShowUserProfile'])->name('myprofile');
});

Route::get('/task', [TaskController::class, 'index']);

Route::get('/task/create', [TaskController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('CreateATask');

Route::get('/task/{task}/edit', [TaskController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('TaskShow');

Route::post('/task', [TaskController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('StoreingTask');

Route::put('/task/{task}', [TaskController::class, 'update'])
    ->name('EditingTask');

Route::delete('/task/{task}', [TaskController::class, 'destroy'])
    ->name('DeleteTask');

Route::get('/task/{task}', [TaskController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('TaskShow');

Route::put('/task/{task}/completedTask', [TaskController::class, 'completedTask'])
    ->middleware(['auth', 'verified'])
    ->name('CompletedTask');

Route::post('/{user}/follow',[FollowerController::class,'follow'])->name('userfollow')->middleware('auth','verified');
Route::post('/{user}/unfollow',[FollowerController::class,'unfollow'])->name('userunfollow')->middleware('auth','verified');

use App\Http\Controllers\CommentController;

Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->middleware('auth','verified')->name('comments.store');

require __DIR__.'/auth.php';
