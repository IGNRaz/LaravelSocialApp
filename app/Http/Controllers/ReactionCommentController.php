<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReaction;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class ReactionCommentController extends Controller
{
    public function like(Task $task, Comment $comment)
    {
        $like = $comment->commentReactions()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
        } else {
            CommentReaction::create([
                'user_id' => Auth::id(),
                'comment_id' => $comment->id,
            ]);
        }

        return back();
    }
}
