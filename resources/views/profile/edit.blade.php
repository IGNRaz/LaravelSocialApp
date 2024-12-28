<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information Form -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Form -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User Form -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>  
            </div>
        </div>
    </div>

</x-app-layout>

<!-- Enhanced Instagram-like Custom CSS -->
<style>
    /* General body styles */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #121212; /* Dark background (black) */
        color: #e0e0e0; /* Light gray text color for better contrast */
    }

    .max-w-7xl {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header styles */
    h2 {
        font-size: 24px;
        font-weight: bold;
        color: #fff;
    }

    /* Profile Picture Section */
    .profile-picture-container {
        text-align: center;
        margin-bottom: 30px;
    }

    .profile-picture {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #ddd; /* Light border around profile picture */
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.6); /* Subtle shadow around the picture */
        transition: all 0.3s ease; /* Smooth transition for hover effect */
    }

    .profile-picture:hover {
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.8); /* Enhanced shadow on hover */
        border-color: #0095f6; /* Border turns Instagram-like blue on hover */
    }

    .change-picture-btn {
        background-color: #0095f6; /* Instagram-like blue */
        color: white;
        padding: 8px 20px;
        border-radius: 5px;
        margin-top: 10px;
        font-weight: bold;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease; /* Add transform effect */
    }

    .change-picture-btn:hover {
        background-color: #007bb5; /* Slightly darker blue on hover */
        transform: scale(1.05); /* Slight scaling effect on hover */
    }

    /* Form Input Styles */
    .form-input-container {
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 600;
        color: #ddd;
        margin-bottom: 8px;
        display: block;
    }

    .form-input {
        width: 100%;
        padding: 12px;
        margin-top: 5px;
        border-radius: 8px;
        border: 1px solid #555;
        background-color: #2a2a2a; /* Dark background for inputs */
        color: #fff;
        font-size: 14px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Smooth transitions */
    }

    .form-input:focus {
        border-color: #0095f6; /* Focus state color */
        box-shadow: 0 0 5px rgba(0, 149, 246, 0.5); /* Subtle blue glow on focus */
        outline: none;
    }

    .form-button {
        background-color: #0095f6; /* Instagram-like blue */
        color: white;
        padding: 12px 20px;
        border-radius: 5px;
        font-weight: bold;
        border: none;
        width: 100%;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease; /* Add transform effect */
    }

    .form-button:hover {
        background-color: #007bb5; /* Darker blue on hover */
        transform: scale(1.05); /* Slight scaling effect on hover */
    }

    .form-button:disabled {
        background-color: #ccc; /* Disabled button color */
        cursor: not-allowed;
    }

    /* Delete User Button */
    .delete-user-btn {
        background-color: #ff3b30; /* Red color for danger */
        color: white;
        padding: 12px 20px;
        border-radius: 5px;
        border: none;
        width: 100%;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease; /* Add transform effect */
    }

    .delete-user-btn:hover {
        background-color: #e53935; /* Slightly darker red on hover */
        transform: scale(1.05); /* Slight scaling effect on hover */
    }

    /* Profile Information Section Styling */
    .profile-info {
        margin-bottom: 20px;
    }

    .profile-info label {
        font-weight: 600;
        color: #ddd; /* Light gray label text */
    }

    .profile-info input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 8px;
        border: 1px solid #555;
        background-color: #2a2a2a;
        color: #fff;
    }

    /* Responsive Design for smaller screens */
    @media (max-width: 768px) {
        .profile-picture {
            width: 120px;
            height: 120px;
        }

        .form-input {
            padding: 10px;
        }

        .form-button, .delete-user-btn {
            padding: 10px;
        }
    }
</style>
