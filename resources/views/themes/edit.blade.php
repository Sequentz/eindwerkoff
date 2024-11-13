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

                    <!-- Word Selection -->
                    <div class="mb-4">
                        <label for="word_ids" class="block text-gray-700 text-sm font-bold mb-2">Select Words:</label>
                        <select name="word_ids[]" id="word_ids" multiple class="w-full border rounded p-2">
                            @foreach($words as $word)
                            <option value="{{ $word->id }}"
                                {{ in_array($word->id, $theme->words->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $word->name }}
                            </option>
                            @endforeach
                        </select>
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
</x-app-layout>