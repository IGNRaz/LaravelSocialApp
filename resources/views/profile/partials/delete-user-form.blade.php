<section class="space-y-6 max-w-4xl mx-auto p-6 bg-gray-900 text-white rounded-lg shadow-md">
    <header>
        <h2 class="text-xl font-semibold text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="w-full p-3 rounded-lg bg-red-600 hover:bg-red-500 text-white"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-gray-800 rounded-lg">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-100">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 p-3 rounded-lg bg-gray-700 text-white border-2 border-gray-600"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <x-secondary-button x-on:click="$dispatch('close')" class="w-1/3 p-3 rounded-lg bg-gray-600 text-white">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="w-1/3 p-3 rounded-lg bg-red-600 hover:bg-red-500 text-white">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

<style>
    .bg-gray-900 {
        background-color: #121212; /* Dark background */
    }
    .bg-gray-800 {
        background-color: #2a2a2a; /* Darker background for modal */
    }
    .bg-gray-700 {
        background-color: #3a3a3a; /* Darker background for input fields */
    }
    .text-gray-400 {
        color: #b0b0b0;
    }
    .text-gray-100 {
        color: #f1f1f1;
    }
    .text-white {
        color: white;
    }
    .bg-red-600 {
        background-color: #e53e3e; /* Red button */
    }
    .hover\:bg-red-500:hover {
        background-color: #f56565;
    }
    .text-white {
        color: white;
    }
    .border-gray-600 {
        border-color: #4a4a4a;
    }
    .w-full {
        width: 100%;
    }
    .p-3 {
        padding: 0.75rem;
    }
    .rounded-lg {
        border-radius: 0.5rem;
    }
    .hover\:bg-red-500:hover {
        background-color: #f56565;
    }
    .gap-4 {
        gap: 1rem;
    }
</style>
