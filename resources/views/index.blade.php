<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: #fff; /* Text color for dark mode */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column; /* Align items vertically */
            justify-content: flex-start; /* Align from the top */
            min-height: 100vh; /* Ensure full page height */
        }
        /* Full-width navigation bar */
        .navbar {
            width: 100%; /* Take full width */
            background-color: #1e1e1e; /* Dark navbar color */
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #333; /* Divider color */
        }
        .navbar a {
            color: #fff; /* Change username color to white */
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
        }
        .navbar a:hover {
            color: #1e90ff;
        }
        .post-container {
            width: 100%;
            max-width: 600px; /* Keep the post container centered and not too wide */
            margin: 20px auto; /* Center horizontally */
            border: 1px solid #333; /* Subtle border for dark mode */
            border-radius: 10px;
            background-color: #1e1e1e; /* Card background for dark mode */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        .post-header {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #333; /* Divider color for dark mode */
        }
        .post-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
        }
        .post-header .username {
            font-weight: bold;
            color: #fff; /* Change username color to white */
        }
        .post-header .username:hover {
            color: #1e90ff; /* Hover effect for username */
        }
        .post-header .post-time {
            color: #b3b3b3; /* Subtle text color for timestamp */
            font-size: 12px;
        }
        .post-content img,
        .post-content video {
            width: 100%;
            display: block;
            max-height: 400px;
            object-fit: cover;
            border-bottom: 1px solid #333; /* Divider between image/video and footer */
        }
        .post-footer {
            padding: 10px 15px;
        }
        .post-footer .interactions {
            display: flex;
            gap: 15px;
            align-items: center;
            font-size: 24px;
        }
        .post-footer .interactions span {
            cursor: pointer;
            color: #b3b3b3; /* Default icon color */
            transition: transform 0.2s ease, color 0.2s ease;
        }
        .post-footer .interactions span:hover {
            transform: scale(1.1);
            color: #fff; /* Bright color on hover */
        }
        .post-footer .interactions .liked {
            color: #ed4956; /* Bright red for liked state */
        }
        .post-footer .description {
            margin-top: 10px;
            color: #fff; /* Text color for descriptions */
            font-size: 14px;
        }
        .post-footer .description span {
            font-weight: bold;
        }
        .flex {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }
        .text-gray-600 {
            color: #777;
        }
        .like-button {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .like-button svg {
            transition: transform 0.2s ease, fill 0.2s ease;
        }
        .like-button:hover svg {
            transform: scale(1.1);
            fill: #ed4956; /* Bright red on hover */
        }
        .like-counter {
            font-size: 12px; /* Small font for like counter */
            color: #b3b3b3; /* Subtle text color */
        }
        <style>
        /* Your existing styles */

        /* Add this for the red color on liked state */
        .liked svg {
            fill: #ed4956; /* Red color when liked */
        }
    </style>
    <script>
        async function toggleLike(event, taskId) {
    event.preventDefault(); // Prevent the default form submission behavior

    const button = document.getElementById(`like-button-${taskId}`);
    const counter = document.getElementById(`like-counter-${taskId}`);

    // Toggle the visual liked state
    const liked = button.classList.contains('liked');
    button.classList.toggle('liked');

    try {
        const response = await fetch(`/tasks/${taskId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ task_id: taskId }),
        });

        const result = await response.json();

        if (response.ok && result.success) {
            // Update the like counter based on the response
            counter.textContent = `${result.likeCount} ${result.likeCount === 1 ? 'Like' : 'Likes'}`;
        } else {
            // If the request failed, revert the UI changes
            button.classList.toggle('liked', liked);
            alert('Failed to toggle like. Please try again.');
        }
    } catch (error) {
        // Handle any errors
        console.error('Error toggling like:', error);
        button.classList.toggle('liked', liked);
    }
}

    </script>
</head>
<body>

    <!-- Tasks List -->
    <div class="flex">
        @forelse ($tasks as $task)
            <div class="post-container">
                <!-- Post Header -->
                <div class="post-header">
                    <a href="{{ route('UserProfile', ['user' => $task->user]) }}">
                        <img src="{{ $task->user->profile_picture ? Storage::url($task->user->profile_picture) : 'https://via.placeholder.com/150' }}" alt="Profile Picture">
                    </a>
                    <div>
                        <a href="{{ route('UserProfile', ['user' => $task->user]) }}" class="username">{{ $task->user->name }}</a>
                        <p class="post-time">{{ $task->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Post Content -->
                <div class="post-content">
                    @if ($task->image)
                        <img src="{{ storage::url($task->image) }}" alt="Task Image">
                    @elseif ($task->video)
                        <video controls>
                            <source src="{{ storage::url($task->video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                </div>

                <!-- Post Footer -->
                <div class="post-footer">
                    <!-- Interactions -->
                    <div class="interactions">
                        <form action="{{route('task.like', ['task' => $task]) }}" method="POST" onsubmit="event.preventDefault(); toggleLike(event, {{ $task->id }}" method="POST">
                            @csrf
                            <button type="submit" class="like-button">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="#b3b3b3"/>
                                </svg>
                            </button>
                        </form>
                        <a href="{{ route('TaskShow',['task' => $task->id]) }}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 6h-2v9H7v2h9l5 5V6z" fill="#b3b3b3"/>
                                <path d="M17 2H3c-1.1 0-2 .9-2 2v14l4-4h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" fill="#b3b3b3"/>
                            </svg>
                        </a>
                        <span> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.12-4.11c.53.48 1.21.77 1.96.77 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.91 9.81c-.53-.48-1.21-.77-1.96-.77-1.66 0-3 1.34-3 3s1.34 3 3 3c.75 0 1.43-.29 1.96-.77l7.12 4.11c-.05.23-.09.46-.09.7 0 1.66 1.34 3 3 3s3-1.34 3-3-1.34-3-3-3z" fill="#b3b3b3"/></span> <!-- Share Icon -->
                    </div>
                    <div class="like-counter">{{ $task->likes->count() }} {{ Str::plural('Like', $task->likes->count()) }}</div>
                    <!-- Description -->
                    <div class="description">
                        <span>{{ $task->user->name }}</span> {{ $task->description }}
                    </div>
                </div>
            </div>
        @empty
            <div class="text-gray-600">Nothing to show.</div>
        @endforelse
    </div>

    <script>
        function toggleLike(element) {
            element.classList.toggle('liked');
        }
    </script>
</body>
