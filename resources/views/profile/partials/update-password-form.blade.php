<section class="max-w-4xl mx-auto p-6 bg-gray-900 text-white rounded-lg shadow-md">
    <header>
        <h2 class="text-xl font-semibold text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="space-y-4">
            <div>
                <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full p-3 rounded-lg border-2 border-gray-600 bg-gray-800 text-white" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password" :value="__('New Password')" />
                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full p-3 rounded-lg border-2 border-gray-600 bg-gray-800 text-white" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full p-3 rounded-lg border-2 border-gray-600 bg-gray-800 text-white" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button class="w-full p-3 rounded-lg bg-blue-600 hover:bg-blue-500 focus:outline-none">
                    {{ __('Save') }}
                </x-primary-button>
            </div>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-400 mt-4"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<style>
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
    .text-green-400 {
        color: #48c78e; /* Green for success message */
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
</style>
