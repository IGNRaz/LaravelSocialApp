<?php
namespace App\Http\Controllers;

use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Comment;


class ReactionController extends Controller
{
    
public function like(Task $task)
{
    $like = Reaction::where('task_id', $task->id)->where('user_id', Auth::id())->first();

    if ($like) {
        $like->delete(); 
    } else {
        Reaction::create([
            'user_id' => Auth::id(),
            'task_id' => $task->id,
        ]);
    }

    return back(); 
}

    
}
