<?php

use App\Http\Controllers\FollowerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReactionCommentController;
use App\Livewire\Chat\CreateChat;
use App\Livewire\Chat\Main;

use App\Models\CommentReaction;
use GuzzleHttp\Middleware;
use PHPUnit\Framework\Attributes\Group;

Route::get('/', function () {
    return view('stuff.welcome');
})->middleware('guest');

Route::get('/user/{user}', [ProfileController::class, 'showProfile'])->name('UserProfile');

Route::get('/dashboard', function () {
    return view('stuff.dashboard', ['tasks' => Task::inRandomOrder()->latest()->Paginate(20)]
  );

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/userprofile', [ProfileController::class,'ShowUserProfile'])->name('myprofile');
    Route::post('/{user}/follow',[FollowerController::class,'follow'])->name('userfollow');
Route::post('/{user}/unfollow',[FollowerController::class,'unfollow'])->name('userunfollow');
Route::post('/reactions', [ReactionController::class, 'store'])->name('reactions.store');

});

Route::middleware(['auth','verified'])->group(function(){
    Route::get('/people', App\Livewire\Chat\CreateChat::class)->name('users');
    Route::get('/chat/{key?}', App\Livewire\Chat\Main::class)->name('chat');
    Route::post('/chat/start/{user}', [App\Livewire\Chat\CreateChat::class, 'handleUserClick'])->name('chat.start');
});

Route::middleware(['auth','verified'])->group(function(){

    Route::get('/post', [TaskController::class, 'index']);

    Route::get('/post/create', [TaskController::class, 'create'])->name('CreateATask');
    
    Route::get('/post/{task}/edit', [TaskController::class, 'edit'])->name('TaskShow');
    
    Route::post('/post', [TaskController::class, 'store'])->name('StoreingTask');
    
    Route::put('/post/{task}', [TaskController::class, 'update'])->name('EditingTask');
    
    Route::delete('/post/{task}', [TaskController::class, 'destroy'])->name('DeleteTask');
    
    Route::get('/post/{task}', [TaskController::class, 'show'])->name('TaskShow');
    
    Route::put('/post/{task}/completedTask', [TaskController::class, 'completedTask'])->name('CompletedTask');

    Route::post('/posts/{task}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::post('/posts/{task}/comments/{comment}/like', [ReactionCommentController::class, 'like'])->name('comments.like');

    Route::post('/posts/{task}/likes', [ReactionController::class, 'like'])->name('task.like');

});

require __DIR__.'/auth.php';
