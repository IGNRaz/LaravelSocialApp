<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #121212; /* Dark mode background */
            color: white;
        }
        nav {
            background-color: #1e1e1e; /* Navbar background */
            border-bottom: 1px solid #1e1e1e;
            padding: 0 20px;
        }
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
            flex-wrap: wrap; /* Allow items to wrap on smaller screens */
        }
        /* Logo */
        .nav-logo {
            font-size: 24px;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }
        /* Search Bar */
        .nav-search {
            flex: 1;
            margin: 0 20px;
        }
        .nav-search input {
            width: 100%;
            padding: 8px 15px;
            background-color: #2b2b2b; /* Input background */
            border: none;
            border-radius: 20px;
            color: white;
            font-size: 14px;
        }
        .nav-search input::placeholder {
            color: #777;
        }
        /* Navigation Links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .nav-links a {
            text-decoration: none;
            color: #b3b3b3; /* Default link color */
            font-size: 16px;
            transition: color 0.2s;
        }
        .nav-links a:hover {
            color: white; /* Highlight on hover */
        }
        /* Profile Avatar */
        .nav-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Hamburger Menu */
        .hamburger {
            display: none;
            flex-direction: column;
            justify-content: space-around;
            width: 25px;
            height: 20px;
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .hamburger div {
            width: 100%;
            height: 3px;
            background-color: #fff;
            border-radius: 5px;
        }

        .hamburger-menu {
            display: none;
            position: absolute;
            top: 60px;
            right: 20px;
            background-color: #1e1e1e;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .hamburger-menu a {
            display: block;
            padding: 8px;
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .hamburger-menu a:hover {
            background-color: #333;
        }

        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                align-items: flex-start;
            }
            .nav-links {
                flex-direction: column;
                gap: 10px;
                margin-top: 10px;
            }
            .nav-search {
                width: 100%;
                margin-top: 10px;
            }
            .hamburger {
                display: flex;
            }
            .nav-links {
                display: none;
                width: 100%;
                flex-direction: column;
                gap: 0;
                margin-top: 10px;
            }
            .nav-links.active {
                display: flex;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <nav>
        <div class="nav-container">
            <!-- Logo -->
            <h1>MyTestApp</h1>
            
            <!-- Search Bar -->
            <div class="nav-search">
                <input type="text" placeholder="Search">
            </div>
            
            <!-- Hamburger Button -->
            <button class="hamburger" id="hamburgerBtn">
                <div></div>
                <div></div>
                <div></div>
            </button>

            <!-- Navigation Links -->
            <div class="nav-links" id="navLinks">
                <a href="{{ route('dashboard') }}">Explore</a>
                <a href="{{ route('CreateATask') }}">Create</a>
                <a href={{route('chat')}}>Messages</a>
                
                <!-- Profile -->
                <a href="{{ route('myprofile') }}" class="nav-profile">
                    <img src="{{ Auth::user()->profile_picture ? Storage::url(Auth::user()->profile_picture) : 'https://via.placeholder.com/40' }}" alt="Profile Picture">
                </a>
            </div>
        </div>
    </nav>

    <!-- Hamburger Menu (for small screens) -->
    <div class="hamburger-menu" id="hamburgerMenu">
        <a href="{{ route('profile.edit') }}">Edit Profile</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background: none; border: none; color: white; font-size: 16px; cursor: pointer;">Log Out</button>
        </form>
    </div>

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-dark-100 dark:bg-dark-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <script>
        // Toggle the navigation menu for mobile view
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const navLinks = document.getElementById('navLinks');
        const hamburgerMenu = document.getElementById('hamburgerMenu');

        hamburgerBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            hamburgerMenu.classList.toggle('active');
        });
    </script>
</body>
</html>
