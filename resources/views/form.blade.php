@extends('layouts.layouts')
@section('title', isset($task) ? 'Edit Tasks' : 'Add Tasks')
@section('content')

@section('style')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f4f8; 
    }

    .container {
        max-width: 600px;
        margin: 40px auto;
        padding: 20px;
        background-color: #ffffff; /
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        color: #5e35b1; 
    }

    .form-group input[type="text"],
    .form-group textarea {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-group input[type="file"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .form-group button[type="submit"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        background-color: #5e35b1;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .form-group button[type="submit"]:hover {
        background-color: #4e27a0;
    }

    .error {
        color: #e74c3c; 
        font-size: 14px;
        margin-top: 5px;
    }
</style>
@endsection

<form method="POST" action="{{ isset($task) ? route('EditingTask', ['task' => $task->id]) : route('StoreingTask') }}" enctype="multipart/form-data">
    @csrf
    @isset($task)
        @method('PUT')
    @endisset
    <div class="container">
        <div class="form-group">
            <label for="title">
                Title
            </label>
            <input type="text" name="title" id="title" value="{{ $task->title ?? old('title') }}">
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label> Description </label>
            <textarea name="description" id="description" rows="5">{{ $task->description ?? old('description') }}</textarea>
            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label> Long Description </label>
            <textarea name="long_description" id="long_description" rows="10">{{ $task->long_description ?? old('long_description') }}</textarea>
            @error('long_description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="hidden" name="user_id" value="{{ Auth::id() }}" >
        </div>
        <div class="form-group">
            <input type="hidden" name="user_name" value="{{ Auth::user()->name }}" >
        </div>

        <div class="form-group">
            <label for="image">
                @isset($task->image)
                    Current Image: <img src="{{ asset('storage/uploads' . $task->id . '/' . basename($task->image)) }}" alt="Task Image">
                @else
                    Upload Image
                @endisset
            </label>
            <input type="file" name="image" accept="image/*">
        </div>

        <div class="form-group">
            <label for="video">
                @isset($task->video)
                    Current Video: <video width="320" height="240" controls>
                        <source src="{{ asset('storage/uploads' . $task->id . '/' . basename($task->video)) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    Upload Video (Optional)
                @endisset
            </label>
            <input type="file" name="video" accept="video/*">
        </div>

        <div class="form-group">
            <button type="submit">
                @isset($task)
                    Update Task
                @else
                    Add Task
                @endisset
            </button>
        </div>
    </div>
</form>

@endsection