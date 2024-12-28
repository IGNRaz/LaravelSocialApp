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
            color: #00b0ff;
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
            color: #00b0ff; /* Bright username color for contrast */
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
    </style>
</head>
<body>

    <!-- Tasks List -->
    <div class="flex">
        @forelse ($tasks as $task)
            <div class="post-container">
                <!-- Post Header -->
                <div class="post-header">
                    <img src="{{ $task->user->profile_picture ? Storage::url($task->user->profile_picture) : 'https://via.placeholder.com/150' }}" alt="Profile Picture">
                    <div>
                        <a href="{{ route('TaskShow', ['task' => $task]) }}" class="username">{{ $task->user->name }}</a>
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
                        <span class="like-button" onclick="toggleLike(this)">&#9829;</span> <!-- Heart Icon -->
                        <span>&#9993;</span> <!-- Comment Icon -->
                        <span>&#x1f517;</span> <!-- Share Icon -->
                    </div>
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
