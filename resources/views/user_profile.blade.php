@extends('layouts.layouts')

@section('content')
<div class="user-info-container">
    @if(isset($user))
        
        <a href="{{ route('dashboard') }}" class="home-link">
            &#8592; <span>Home</span>
        </a>
        <div class="user-profile-picture">
            <img src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://via.placeholder.com/120' }}" 
                alt="Profile Picture" 
                class="profile-picture">
        </div>
        <div class="user-info">
            <p class="user-name">{{ $user->name ?? 'No name' }}</p>
            <p class="user-id">{{"@".$user->usernames ?? 'No ID available' }}</p>
            <div class="follow-info">
                <span>{{ $user->following()->count() }}</span> Following
                <span>{{ $user->followers()->count() }}</span> Followers
            </div>
            @if(Auth::id() != $user->id)
                @if(Auth::user()->follows($user))
                    <form method="POST" action="{{ route('userunfollow', $user->id) }}">
                        @csrf
                        <button type="submit" class="unfollow-button">Unfollow</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('userfollow', $user->id) }}">
                        @csrf
                        <button type="submit" class="follow-button">Follow</button>
                    </form>
                @endif
            @endif
        </div>
    @else
        <p class="no-user-data">No user data available.</p>
    @endif
</div>

<div class="user-posts">
    @if(isset($user->tasks) && count($user->tasks) > 0)
        @foreach($user->tasks->sortByDesc('created_at') as $task) 
            <a href="{{ route('TaskShow', ['task' => $task->id]) }}" class="post">
                <div class="post-picture-container">
                    
                    @if($task->image)
                        <img src="{{Storage::url($task->image) }}" alt="Task Picture" class="post-picture">
                    @elseif($task->video)
                        <video class="post-picture" controls>
                            <source src="{{ Storage::url($task->video )}}" typae="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                </div>
                <p class="post-name">{{ $task->title }}</p>
                
            </a>
        @endforeach
    @else
        <p>No posts found.</p>
    @endif
</div>

@endsection

<style>
/* General Styles */
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #121212;
    color: #e3e3e3;
}

.user-info-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background-color: #1f1f1f;
    border-radius: 12px;
    margin: 20px auto;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    max-width: 500px;
}

.user-profile-picture {
    margin-bottom: 15px;
}

.profile-picture {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #444;
}

.user-info {
    text-align: center;
}

.user-name {
    font-size: 22px;
    font-weight: 600;
    color: #fff;
    margin-bottom: 5px;
}

.user-id {
    font-size: 14px;
    color: #b0b0b0;
    margin-top: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.follow-info {
    font-size: 14px;
    color: #b0b0b0;
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 15px;
}

.follow-info span {
    font-weight: bold;
}

.follow-button,
.unfollow-button {
    display: inline-block;
    padding: 8px 20px;
    font-size: 14px;
    font-weight: bold;
    text-decoration: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.follow-button {
    background-color: #0095f6;
    color: white;
}

.follow-button:hover {
    background-color: #007bb5;
}

.unfollow-button {
    background-color: #dc3545;
    color: white;
}

.unfollow-button:hover {
    background-color: #bd2130;
}

/* Post Grid Styles */
.user-posts {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 10px;
    padding: 20px;
    margin: 0 auto;
    max-width: 500px;
}

.post {
    position: relative;
    border-radius: 5px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.post:hover {
    transform: scale(1.05);
}

.post-picture-container {
    width: 100%;
    height: 150px;
    overflow: hidden;
}

.post-picture {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 5px;
    background-color: #333;
}

.post-name {
    position: absolute;
    bottom: 5px;
    left: 5px;
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    font-size: 14px;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 3px;
}

.post-type-label {
    font-size: 12px;
    color: #fff;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 2px 6px;
    margin-top: 5px;
    border-radius: 3px;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .user-info-container {
        padding: 15px;
        max-width: 90%;
    }

    .profile-picture {
        width: 100px;
        height: 100px;
    }

    .user-name {
        font-size: 18px;
    }

    .follow-info {
        font-size: 12px;
    }

    .follow-button,
    .unfollow-button {
        font-size: 12px;
        padding: 6px 15px;
    }

    .user-posts {
        padding: 10px;
    }
}

/* Home Link Styles */
.home-link {
    position: absolute;
    top: 10px;
    left: 10px;
    color: #fff;
    text-decoration: none;
    font-size: 20px;
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: transform 0.3s ease, color 0.3s ease;
}

.home-link span {
    margin-left: 5px;
}

.home-link:hover {
    transform: scale(1.1);
    color: #0095f6;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const homeLink = document.querySelector('.home-link');
    homeLink.addEventListener('mouseover', function() {
        this.style.transform = 'scale(1.1)';
    });
    homeLink.addEventListener('mouseout', function() {
        this.style.transform = 'scale(1)';
    });
});
</script>

