@extends('layouts.layouts')

@section('content')
<div class="task-container">
    <div class="task-header">
        <div class="task-header-top">
            <div class="home-icon">
                <a href="{{ route('dashboard') }}">
                    <span>&#8962;</span> <!-- Home Icon -->
                </a>
            </div>
            
            <div class="user-info-box">
                <a href="{{ route('UserProfile', [$task->user->id]) }}" class="user-profile-link">
                    <div class="user-profile-picture">
                        <img src="{{ Auth::user()->profile_picture ? Storage::url($task->user->profile_picture) : 'https://via.placeholder.com/120' }}" 
                             alt="Profile Picture" 
                             class="profile-picture">
                    </div>
                    <div class="user-name">
                        <h1 class="task-title">{{ $task->user->name }}</h1>
                    </div>
                </a>
            </div>
          
            @if(Auth::user()->id === $task->user_id) <!-- Authorization Check -->
                <div class="three-dots-menu">
                    <span class="dots-icon">&#8230;</span>
                    <div class="dropdown-content">
                        <a href="{{ route('EditingTask', ['task' => $task]) }}/edit">Edit Task</a>
                        <form method="POST" action="{{ route('CompletedTask',['task'=>$task]) }}">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="mark-completed-button">Mark as {{$task->completed ? 'not completed' : 'completed'}}</button>
                        </form>
                        <form action="{{ route('DeleteTask', ['task' => $task->id]) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="delete-button">Delete</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="task-content">
        <p class="task-description"></p>
        <p class="task-long-description"></p>

        <!-- Media Carousel -->
        @if($task->image || $task->video) <!-- Check if image or video exists -->
        <div class="task-carousel">
            <div class="carousel-wrapper">
                @if($task->image)
                <div class="carousel-item">
                    <img src="{{ Storage::url($task->image) }}" alt="Task Image">
                </div>
                @endif
                @if($task->video)
                <div class="carousel-item">
                    <video controls>
                        <source src="{{ Storage::url($task->video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                @endif
            </div>
            <div class="carousel-navigation">
                <button class="carousel-prev">&#8249;</button>
                <button class="carousel-next">&#8250;</button>
            </div>
        </div>
        @endif

        <!-- Like and Comment Section Styled like Instagram -->
        <div class="task-like-section">
            <form action="{{ route('task.like', $task) }}" method="POST" style="display: inline;">
                @csrf
                @php
                    $userLiked = $task->likes->where('user_id', Auth::id())->first();
                @endphp
                <button type="submit" class="like-icon">
                    <svg class="heart-icon {{ $userLiked ? 'liked' : '' }}" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </button>
            </form>
            <span class="like-counter">{{ $task->likes->count() }} {{ Str::plural('Like', $task->likes->count()) }}</span>
        </div>

        <!-- Comments Section -->
        <div class="comments-section">
            <div class="comment">
                <p class="post-user">{{ $task->user->name }}</p>
                <p class="post-description">{{ $task->description }}</p>
                <p class="post-long-description">{{ $task->long_description }}</p>
                
                
            </div>
        </div>
        
        <!-- Task Time Section -->
        <p class="task-time">Posted on {{ $task->created_at->diffForHumans() }}</p>
        
   <!-- Comments Section -->
   <div class="comments-section">
    <h3>Comments</h3>
    <ul class="comments-list">
        @foreach ($task->comments as $comment)
        <li class="comment-item">
            <div class="comment-header">
                <div class="commenter-picture">
                    <img src="{{ $comment->user->profile_picture ? Storage::url($comment->user->profile_picture) : 'https://via.placeholder.com/50' }}" alt="Commenter Picture">
                </div>
                <strong class="comment-author">
                    {{ $comment->user->name }}
                    <!-- Check if the user is the author of the task -->
                    @if ($comment->user_id == $task->user_id)
                    <small class="author-label">Author</small>
                    @endif
                </strong>
                <small class="comment-time">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
            <div class="comment-content-wrapper">
                <p class="comment-content">{{ $comment->content }}</p>
                <div class="comment-like-section">
                    <form action="{{ route('comments.like', ['task' => $task->id, 'comment' => $comment->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        @php
                            $userLiked = $comment->commentReactions->where('user_id', Auth::id())->first();
                        @endphp
                        <button type="submit" class="like-icon">
                            <svg class="heart-icon {{ $userLiked ? 'liked' : '' }}" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>
                        <span class="comment-like-counter">{{ $comment->commentReactions->count() }} {{ Str::plural('Like', $comment->commentReactions->count()) }}</span>
                    </form>
                </div>
            </div>
        </li>
        @endforeach
    </ul>

    <!-- Comment Form -->
    <form action="{{ route('comments.store', $task->id) }}" method="POST" class="comment-form">
        @csrf
        <textarea name="content" rows="2" placeholder="Write a comment..." required></textarea>
        <button type="submit" class="add-comment-button">Add Comment</button>
    </form>
</div>

@endsection


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const carouselWrapper = document.querySelector('.carousel-wrapper');
        const carouselItems = document.querySelectorAll('.carousel-item');
        const prevButton = document.querySelector('.carousel-prev');
        const nextButton = document.querySelector('.carousel-next');
    
        let currentIndex = 0;
    
        function updateCarousel() {
            const offset = -currentIndex * 100;
            carouselWrapper.style.transform = `translateX(${offset}%)`;
        }
    
        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + carouselItems.length) % carouselItems.length;
            updateCarousel();
        });
    
        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % carouselItems.length;
            updateCarousel();
        });
    });
    </script>

<style>
/* General Styling */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #121212;
    color: #fff;
    overflow-x: hidden;
}

/* Task Container */
.task-container {
    max-width: 500px;
    margin: 40px auto;
    padding: 10px;
    background-color: #1c1c1c;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    border: 1px solid #444;
    opacity: 0;
    animation: fadeIn 0.5s forwards;
}

/* Home Icon */
.home-icon {
    font-size: 24px;
    color: #fff;
    cursor: pointer;
    margin-right: 20px;
    transition: transform 0.3s ease, color 0.3s ease;
}

.home-icon a {
    color: #fff;
    text-decoration: none;
}

.home-icon:hover {
    transform: scale(1.2);
    color: #00B0FF;
}

/* Task Header */
.task-header {
    position: relative;
    margin-bottom: 15px;
}

.task-header-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.user-info-box {
    display: flex;
    align-items: center;
    gap: 15px;
    flex: 1;
}

.user-profile-picture {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
}

.profile-picture {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-name {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
}

.task-title {
    font-size: 18px;
    font-weight: bold;
    margin: 0;
    color: #fff;
}

.task-time {
    font-size: 12px;
    color: #777;
    margin-top: 5px;
    text-align: left;
}

/* Three Dots Menu */
.three-dots-menu {
    cursor: pointer;
    position: relative; /* Add position relative */
}

.dots-icon {
    font-size: 24px;
    color: #777;
    transition: color 0.3s;
}

.dots-icon:hover {
    color: #fff;
    transform: scale(1.2);
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    top: 30px;
    background-color: #333;
    color: #fff;
    min-width: 150px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    border-radius: 8px;
    z-index: 1;
    text-align: left; /* Align text to the left */
}

.dropdown-content a, .dropdown-content button {
    display: block;
    padding: 10px;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    border: none;
    background-color: transparent;
    width: 100%;
    text-align: left;
}

.dropdown-content a:hover, .dropdown-content button:hover {
    background-color: #444;
}

.three-dots-menu:hover .dropdown-content {
    display: block;
}

/* Task Content */
.task-content {
    margin-top: 15px;
    opacity: 0;
    animation: fadeIn 0.5s ease 0.5s forwards;
}

.task-description, .task-long-description {
    font-size: 14px;
    line-height: 1.6;
    margin-top: 10px;
    text-align: left; /* Align text to the left */
}

.task-image img {
    width: 100%;
    border-radius: 8px;
    margin-top: 15px;
    animation: fadeIn 0.5s ease 1s forwards;
}

/* Like and Comment Buttons */
.task-interactions {
    display: flex;
    justify-content: center; /* Center the buttons */
    gap: 20px; /* Add space between buttons */
    margin-top: 15px;
    padding: 0 10px;
}

.like-button, .comment-button, .share-button {
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    color: #fff;
}

.like-button:hover, .comment-button:hover, .share-button:hover {
    transform: scale(1.1);
}

.like-button.liked {
    color: #F44336; /* Red when liked */
}

.share-button {
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    color: #fff;
    transition: transform 0.3s ease, color 0.3s ease;
}

.share-button:hover {
    transform: scale(1.1);
    color: #00B0FF; /* Change color on hover */
}

.share-button.shared {
    color: #fff; /* Keep white when shared */
}

.comment-button {
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    color: #fff;
    transition: transform 0.3s ease, color 0.3s ease;
}

.comment-button:hover {
    transform: scale(1.1);
    color: #00B0FF; /* Change color on hover */
}

/* Comments Section */
.comments-section {
    margin-top: 20px;
    padding: 0 10px;    
}

.comment {
    margin-top: 10px;
    text-align: left;
     /* Align all comment text to the left */
}

.username {
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    text-align: left; /* Align username to the left */
}

.comment-description, .comment-long-description {
    font-size: 14px;
    color: #ccc;
    margin-top: 5px;
    text-align: left; /* Align description to the left */
}

.user-profile-link {
    display: flex;
    align-items: center;
    gap: 15px;
    text-decoration: none; /* Removes underline */
    color: inherit; /* Inherits text color */
    transition: color 0.3s ease;
}

.user-profile-link:hover {
    color: #00B0FF; /* Changes color on hover */
}

.task-image video {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-top: 15px;
    animation: fadeIn 0.5s ease 1s forwards;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
.task-carousel {
    position: relative;
    overflow: hidden;
    margin-top: 15px;
    border-radius: 8px;
}

.carousel-wrapper {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.carousel-item {
    min-width: 100%;
    flex-shrink: 0;
    text-align: center; /* Center content inside each item */
    position: relative;
}

.carousel-item img, 
.carousel-item video {
    width: auto;
    max-height: 500px;
    max-width: 100%;
    margin: 0 auto;
    border-radius: 8px;
    object-fit: cover;
}

.carousel-navigation {
    position: absolute;
    top: 50%;
    width: 100%;
    display: flex;
    justify-content: space-between;
    transform: translateY(-50%);
}

.carousel-prev, .carousel-next {
    background-color: rgba(0, 0, 0, 0.5);
    border: none;
    color: #fff;
    font-size: 24px;
    padding: 10px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
}

.carousel-prev:hover, .carousel-next:hover {
    background-color: rgba(0, 0, 0, 0.7);
    transform: scale(1.2);
}

.carousel-indicators {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
}

.carousel-indicator {
    width: 10px;
    height: 10px;
    background-color: rgba(255, 255, 255, 0.5);
    border-radius: 50%;
    cursor: pointer;
    transition: background-color 0.3s;
}

.carousel-indicator.active {
    background-color: #fff;
}

/* Comments Section */
.comments-section {
    margin-top: 20px;
    padding: 15px;
    background-color: #1c1c1c;
    border-radius: 10px;
    border: 1px solid #444;
}

.comments-section h3 {
    margin-bottom: 15px;
    font-size: 18px;
    color: #fff;
    border-bottom: 1px solid #444;
    padding-bottom: 5px;
}

.comments-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.comment-item {
    margin-bottom: 15px;
    border-bottom: 1px solid #444;
    padding-bottom: 10px;
}

.comment-header {
    display: flex;
    align-items: center;
    gap: 10px;
}

    .commenter-picture {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
    }

    .commenter-picture img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .comment-author {
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    margin-left: 10px; /* Adds space between picture and text */
}

.comment-time {
    font-size: 12px;
    color: #777;
}

.comment-content-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}

.comment-content {
    font-size: 14px;
    color: #ccc;
    margin-top: 5px;
    line-height: 1.6;
}

/* Comment Form */
.comment-form {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.comment-form textarea {
    width: 100%;
    resize: none;
    padding: 10px;
    font-size: 14px;
    border-radius: 5px;
    background-color: #333;
    color: #fff;
    border: 1px solid #555;
}

.comment-form textarea:focus {
    border-color: #00B0FF;
    outline: none;
}

.add-comment-button {
    align-self: flex-end;
    padding: 8px 15px;
    background-color: #00B0FF;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.add-comment-button:hover {
    background-color: #0084c4;
}

.comments-container {
    margin-top: 20px;
    padding: 10px;
    background-color: #1c1c1c;
    border-radius: 8px;
    border: 1px solid #444;
    animation: fadeIn 0.5s ease;
}

.comment-box {
    padding: 10px;
    margin-bottom: 15px;
    background-color: #2a2a2a;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    transition: background-color 0.3s;
}

.comment-box.my-comment {
    background-color: #333; /* Highlight for user's comments */
    border-left: 4px solid #00B0FF;
}

.comment-box:hover {
    background-color: #444;
}

.comment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    font-weight: bold;
    color: #fff;
}

.author-tag {
    font-size: 12px;
    color: #00B0FF;
    margin-left: 5px;
}

.comment-content {
    margin-top: 5px;
    font-size: 14px;
    color: #ccc;
    line-height: 1.5;
}

.comment-timestamp {
    margin-top: 5px;
    font-size: 12px;
    color: #777;
    text-align: right;
    display: block;
}

/* Like Button */
.like-icon {
    background: none;
    border: none;
    cursor: pointer;
    outline: none;
    font-size: 24px;
    color: #fff;
    transition: transform 0.3s ease, color 0.3s ease;
}

.heart-icon {
    fill: #777;
    width: 24px;
    height: 24px;
    transition: fill 0.3s ease, transform 0.3s ease;
}

.heart-icon.liked {
    fill: #F44336; /* Red when liked */
}

.like-icon:hover .heart-icon {
    transform: scale(1.2);
    fill: #F44336;
}

.task-like-section {
    display: flex;
    justify-content: flex-start; /* Move to the left side */
    align-items: center;
    gap: 5px;
}

.like-counter {
    font-size: 12px;
    color: #ccc;
    position: relative;
    top: -8px; /* Move the like counter 3 pixels higher */
}

.comment-content-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}

.comment-like-section {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.comment-like-counter {
    font-size: 12px;
    color: #ccc;
    margin-top: 5px;
    display: block;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const carouselWrapper = document.querySelector('.carousel-wrapper');
    const carouselItems = document.querySelectorAll('.carousel-item');
    const prevButton = document.querySelector('.carousel-prev');
    const nextButton = document.querySelector('.carousel-next');
    const indicatorsContainer = document.createElement('div');
    indicatorsContainer.classList.add('carousel-indicators');
    document.querySelector('.task-carousel').appendChild(indicatorsContainer);

    let currentIndex = 0;

    function updateCarousel() {
        const offset = -currentIndex * 100;
        carouselWrapper.style.transform = `translateX(${offset}%)`;
        document.querySelectorAll('.carousel-indicator').forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentIndex);
        });
    }

    function createIndicators() {
        carouselItems.forEach((_, index) => {
            const indicator = document.createElement('div');
            indicator.classList.add('carousel-indicator');
            if (index === 0) indicator.classList.add('active');
            indicator.addEventListener('click', () => {
                currentIndex = index;
                updateCarousel();
            });
            indicatorsContainer.appendChild(indicator);
        });
    }

            indicator.classList.toggle('active', index === currentIndex);
        });
    }

    function createIndicators() {
        carouselItems.forEach((_, index) => {
            const indicator = document.createElement('div');
            indicator.classList.add('carousel-indicator');
            if (index === 0) indicator.classList.add('active');
            indicator.addEventListener('click', () => {
                currentIndex = index;
                updateCarousel();
            });
            indicatorsContainer.appendChild(indicator);
        });
    }

    prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + carouselItems.length) % carouselItems.length;
        updateCarousel();
    });

    nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % carouselItems.length;
        updateCarousel();
    });

    createIndicators();
    updateCarousel();

</script>

</style>
