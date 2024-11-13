<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Words') }}
            </h2>
            <!-- Add Word Button -->
            <a href="{{ route('words.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Word
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if($words->count() > 0)
                <table class="w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">ID</th>
                            <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">Word</th>
                            <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">Themes</th>
                            <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($words as $word)
                        <tr>
                            <td class="py-2 px-4 border-b text-center">{{ $word->id }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $word->name }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                @if($word->themes->count() > 1)
                                <!-- If the word has multiple themes, show the count -->
                                <span class="inline-block bg-gray-200 px-2 py-1 text-xs font-semibold text-gray-700 rounded">
                                    {{ $word->themes->count() }} Themes
                                </span>
                                @elseif($word->themes->count() === 1)
                                <!-- If the word has only one theme, show the theme name -->
                                <span class="inline-block bg-gray-200 px-2 py-1 text-xs font-semibold text-gray-700 rounded">
                                    {{ $word->themes->first()->name }}
                                </span>
                                @else
                                <!-- If the word has no themes, show a default message -->
                                <span class="inline-block bg-gray-200 px-2 py-1 text-xs font-semibold text-gray-700 rounded">
                                    No Themes
                                </span>
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b text-center space-x-2">
                                <a href="{{ route('words.show', $word->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Show</a>
                                <a href="{{ route('words.edit', $word->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Edit</a>
                                <form action="{{ route('words.destroy', $word->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-4">
                    {{ $words->links() }}
                </div>
                @else
                <div class="text-center py-6">
                    <p class="text-gray-500">No words found.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>