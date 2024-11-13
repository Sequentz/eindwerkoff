<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Theme') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('themes.update', $theme->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="theme" class="block text-gray-700 text-sm font-bold mb-2">Theme Name:</label>
                        <input type="text" id="theme" name="name" value="{{ old('name', $theme->name) }}" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                        @error('name')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>



                    <!-- Add New Word -->
                    <div class="mb-4">
                        <label for="new_word" class="block text-gray-700 text-sm font-bold mb-2">Add New Word:</label>
                        <input type="text" id="new_word" name="new_word" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                        <button type="button" id="add_word" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Add Word</button>
                    </div>

                    <!-- List of Added Words -->
                    <div id="added_words_list" class="mb-4">
                        <h3 class="font-bold text-gray-700">Words to Add:</h3>
                        <ul id="words_list" class="list-disc pl-5">
                            <!-- Added words will be shown here -->
                        </ul>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Update Theme
                        </button>
                        <a href="{{ route('themes.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add_word').addEventListener('click', function() {
            let newWordInput = document.getElementById('new_word');
            let wordValue = newWordInput.value.trim();

            if (wordValue) {
                // Add the word to the list
                let wordList = document.getElementById('words_list');
                let listItem = document.createElement('li');
                listItem.classList.add('text-gray-700', 'flex', 'items-center', 'space-x-2');
                listItem.innerHTML = `
                    <span>${wordValue}</span>
                    <button type="button" class="text-red-500" onclick="removeWord(this)">Remove</button>
                    <input type="hidden" name="words_to_add[]" value="${wordValue}">
                `;
                wordList.appendChild(listItem);

                // Clear the input field
                newWordInput.value = '';
            }
        });

        function removeWord(button) {
            let listItem = button.parentElement;
            listItem.remove();
        }
    </script>
</x-app-layout>