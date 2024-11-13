<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Word') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('words.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Word:</label>
                        <input type="text" id="name" name="name" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none" required>
                    </div>

                    <div class="mb-4">
                        <label for="themes" class="block text-gray-700 text-sm font-bold mb-2">Themes:</label>
                        <div class="space-y-2">
                            @foreach($themes as $theme)
                            <div>
                                <input type="checkbox" id="theme_{{ $theme->id }}" name="themes[]" value="{{ $theme->id }}" class="mr-2">
                                <label for="theme_{{ $theme->id }}" class="text-gray-700">{{ $theme->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create Word
                        </button>
                        <a href="{{ route('words.index') }}" class="text-blue-500 hover:text-blue-800 font-bold">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>