<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Words') }}
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

                <form action="{{ route('words.store') }}" method="POST">
                    @csrf

                    <div id="words-container">
                        <!-- Dynamically added word fields will go here -->
                        <div class="word-row mb-4">
                            <div class="flex space-x-4">
                                <div class="w-1/2">
                                    <label for="name" class="block text-gray-700">Word</label>
                                    <input type="text" name="words[0][name]" class="mt-1 p-2 border border-gray-300 rounded w-full" placeholder="Enter word" required>
                                    @error('words.0.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="w-1/2">
                                    <label for="themes" class="block text-gray-700">Themes</label>
                                    <div class="space-y-2">
                                        @foreach($themes as $theme)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="words[0][themes][]" value="{{ $theme->id }}" class="mr-2">
                                            <label for="themes" class="text-gray-700">{{ $theme->name }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                    @error('words.0.themes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <button type="button" id="add-word-button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Add Another Word
                        </button>

                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Save Words
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add new word input row
        document.getElementById('add-word-button').addEventListener('click', function() {
            var wordsContainer = document.getElementById('words-container');
            var wordCount = wordsContainer.getElementsByClassName('word-row').length;

            // Create a new word row
            var newRow = document.createElement('div');
            newRow.classList.add('word-row', 'mb-4');
            newRow.innerHTML = `
                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <label for="name" class="block text-gray-700">Word</label>
                        <input type="text" name="words[${wordCount}][name]" class="mt-1 p-2 border border-gray-300 rounded w-full" placeholder="Enter word" required>
                    </div>
                    <div class="w-1/2">
                        <label for="themes" class="block text-gray-700">Themes</label>
                        <div class="space-y-2">
                            @foreach($themes as $theme)
                                <div class="flex items-center">
                                    <input type="checkbox" name="words[${wordCount}][themes][]" value="{{ $theme->id }}" class="mr-2">
                                    <label for="themes" class="text-gray-700">{{ $theme->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            `;
            wordsContainer.appendChild(newRow);
        });
    </script>
</x-app-layout>