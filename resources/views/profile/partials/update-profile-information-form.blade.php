<section class="max-w-4xl mx-auto p-6 bg-gray-900 text-white rounded-lg shadow-md">
    <header class="flex items-center space-x-4">
        <!-- Profile Picture Section -->
        <img src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://via.placeholder.com/150' }}" alt="Current Profile Picture" class="w-20 h-20 rounded-full border-4 border-gray-500">
        <div>
            <h2 class="text-xl font-semibold text-gray-100">
                {{ __('Profile Information') }}
            </h2>
            <p class="mt-1 text-sm text-gray-400">
                {{ __("Update your account's profile information and email address.") }}
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <!-- Name Input -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full p-3 rounded-lg bg-gray-800 text-white border-2 border-gray-600 focus:border-blue-500" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email Input -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full p-3 rounded-lg bg-gray-800 text-white border-2 border-gray-600 focus:border-blue-500" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-400">
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification" class="underline text-sm text-gray-500 hover:text-gray-300 focus:outline-none">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-400">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Profile Picture Input -->
            <div>
                <x-input-label for="profile_picture" :value="__('Profile Picture')" />
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="mt-1 block w-full p-3 rounded-lg bg-gray-800 text-white border-2 border-gray-600 focus:border-blue-500" />
                <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
                <img id="profile-picture-preview" src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://via.placeholder.com/150' }}" alt="New Profile Picture Preview" class="w-20 h-20 rounded-full mt-2 border-4 border-gray-500">
                <script>
                    document.getElementById('profile_picture').addEventListener('change', function(event) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('profile-picture-preview').src = e.target.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    });
                </script>
            </div>

            <!-- Save Changes Button -->
            <div class="flex items-center gap-4">
                <x-primary-button type="submit" class="w-full p-3 rounded-lg bg-blue-600 hover:bg-blue-500 focus:outline-none">
                    {{ __('Save Changes') }}
                </x-primary-button>
            </div>

            <!-- Success Message -->
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-300 mt-4"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<style>
    /* General Background and Text Colors */
    .bg-gray-900 {
        background-color: #121212; /* Dark background */
    }
    .bg-gray-800 {
        background-color: #2a2a2a; /* Darker input background */
    }
    .text-gray-400 {
        color: #b0b0b0;
    }
    .text-gray-100 {
        color: #f1f1f1;
    }
    .text-gray-300 {
        color: #a0a0a0;
    }
    .text-blue-500 {
        color: #3490dc;
    }
    .bg-blue-600 {
        background-color: #1d72b8;
    }
    .bg-blue-500 {
        background-color: #3490dc;
    }
    .border-gray-600 {
        border-color: #4a4a4a;
    }
    .hover\:bg-blue-500:hover {
        background-color: #3490dc;
    }

    /* Profile Picture Styling */
    .w-20 {
        width: 5rem; /* Width of the profile picture */
    }
    .h-20 {
        height: 5rem; /* Height of the profile picture */
    }
    .rounded-full {
        border-radius: 9999px; /* Full circle */
    }
    .border-4 {
        border-width: 4px; /* Border for the profile picture */
    }
    .border-gray-500 {
        border-color: #6b7280; /* Subtle border color */
    }

    /* Input and Button Styles */
    .rounded-lg {
        border-radius: 0.5rem; /* Rounded corners */
    }
    .p-3 {
        padding: 0.75rem; /* Padding inside inputs */
    }
    .w-full {
        width: 100%; /* Full-width inputs */
    }
    .focus\:border-blue-500:focus {
        border-color: #3490dc; /* Blue border on focus */
    }

    /* Button Styling */
    .bg-blue-600 {
        background-color: #1d72b8;
    }
    .hover\:bg-blue-500:hover {
        background-color: #3490dc;
    }

    /* Input Placeholder Styling */
    .text-sm {
        font-size: 0.875rem; /* Smaller font size for labels */
    }
</style>
