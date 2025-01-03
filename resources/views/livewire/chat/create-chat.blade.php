@extends('components.layouts.app')
@section('content')
<ul class="w-75 mx-auto mt-3 container-fluid" style="height: 1000px; list-style-type: none; padding: 0;">
    @foreach ($users as $user)
        <li class="user-item">
            <form method="POST" action="{{ route('chat.start', ['user' => $user->id]) }}" class="w-100 h-100">
                @csrf
                <button type="submit" class="btn btn-link text-decoration-none w-100 h-100">
                    <img src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://via.placeholder.com/120' }}"  class="profile-picture">
                    {{$user->name}}
                </button>
            </form>
        </li>
    @endforeach
</ul>

<style>
    .user-item {
        border: 1px solid #4a4a4a;
        padding: 10px; /* Reduced padding to make the box smaller */
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        background-color: #4a4a4a;
        transition: background-color 0.3s ease;
        border-radius: 8px;
    }

    .user-item:hover {
        background-color: #4a4a4a;
    }

    .profile-picture {
        width: 40px; /* Reduced size to make the box smaller */
        height: 40px; /* Reduced size to make the box smaller */
        border-radius: 50%;
        margin-right: 10px; /* Reduced margin to make the box smaller */
        border: 2px solid #ddd;
    }

    .btn-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #f1f1f1;
        font-weight: bold;
        font-size: 1.1em;
        width: 100%;
        height: 100%;
    }

    .btn-link:hover {
        color: #ddd; /* Dark gray color */
    }
</style>
@endsection
