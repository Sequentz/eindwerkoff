<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add themes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if(session('success'))
                <div class="mb-4 text-green-500">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('themes.store') }}" method="POST">
                    @csrf

                    <div id="themes-container">
                        <!-- Dynamically added theme fields will go here -->
                        <div class="theme-row mb-4">
                            <div class="flex space-x-4">
                                <div class="w-1/2">
                                    <label for="name" class="block text-gray-700">Theme</label>
                                    <input type="text" name="themes[0][name]" class="mt-1 p-2 border border-gray-300 rounded w-full" placeholder="Enter theme" required>
                                    @error('themes.0.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <button type="button" id="add-theme-button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Add Another theme
                        </button>

                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Save themes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add new theme input row
        document.getElementById('add-theme-button').addEventListener('click', function() {
            var themesContainer = document.getElementById('themes-container');
            var themeCount = themesContainer.getElementsByClassName('theme-row').length;

            // Create a new theme row
            var newRow = document.createElement('div');
            newRow.classList.add('theme-row', 'mb-4');
            newRow.innerHTML = `
                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <label for="name" class="block text-gray-700">Theme</label>
                        <input type="text" name="themes[${themeCount}][name]" class="mt-1 p-2 border border-gray-300 rounded w-full" placeholder="Enter theme" required>
                    </div>
                </div>
            `;
            themesContainer.appendChild(newRow);
        });
    </script>
</x-app-layout>