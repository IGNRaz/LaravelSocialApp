<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        return redirect('dashboard');
    }

    public function create()
    {
        return view('stuff.create');
    }

    public function edit(Task $task)
    {
        if ($task->user_id != Auth::id()) {
            abort(403);
        }
        return view('stuff.edit', ['task' => $task]);
    }

    public function store(TaskRequest $request)
    {
        $imagePath = null; 
        $videoPath = null; 
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/pic', 'public');
        }
    
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('uploads/vid', 'public');
        }

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->long_description = $request->long_description;
        $task->user_id = Auth::id();
    
        if ($imagePath && $videoPath) {
            $task->saveImage($imagePath, $videoPath);
        } elseif ($imagePath) {
            $task->saveImage($imagePath, null);
        } elseif ($videoPath) {
            $task->saveImage(null, $videoPath);
        }

        $task->save();
    
        if ($imagePath || $videoPath) {
            $task->saveImage($imagePath, $videoPath);
        }
        return redirect()->route('dashboard')->with('success', '');
    }  

    public function update(Task $task, TaskRequest $request)
    {
        if ($task->user_id != Auth::id()) {
            abort(403);
        }
        $validatedData = $request->validate($request->rules());
        $task->update($validatedData);

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $destinationPath = storage_path('app/public/uploads');
            $file->move($destinationPath, $filename);
            $task->image = "uploads/{$filename}";
            $task->image = "uploads/{$filename}";
            $task->save();
        }
        return redirect()->route('TaskShow', ['task' => $task->id]);
    }

    public function destroy(Task $task){
        if ($task->user_id != Auth::id()) {
            abort(403);
        }
        $task->delete();
        return redirect()->route('dashboard')->with('success', 'Task deleted');
    }

    public function show(Task $task)
    {
        return view('stuff.show', ['task' => $task, 'user_name' => $task->user->name]);
    }

    public function completedTask(Task $task)
    {
        $task->CompletedTask();
        return redirect()->back()->with('success', 'Task Completed');
    }


}
