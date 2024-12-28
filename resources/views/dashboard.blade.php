<x-app-layout>
    <div class="py-12">
        <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-black overflow-hidden shadow-sm sm:rounded-lg"> <!-- Pure black background -->
                <div class="p-6 text-white"> <!-- Pure white text for contrast -->
                  @include('index')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
