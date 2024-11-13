<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Themes') }}
            </h2>
            <!-- Add Theme Button -->
            <a href="{{ route('themes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Theme
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Check if there are themes -->
                @if($themes->count() > 0)
                <!-- Themes Table -->
                <table class="w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">
                                @sortablelink('id', 'ID')
                            </th>
                            <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">
                                @sortablelink('theme', 'Theme')
                            </th>
                            <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($themes as $theme)
                        <tr>
                            <td class="py-2 px-4 border-b text-center">{{ $theme->id }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $theme->name }}</td>
                            <td class="py-2 px-4 border-b text-center space-x-2">
                                <!-- Show Button -->
                                <a href="{{ route('themes.show', $theme->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Show</a>

                                <!-- Edit Button -->
                                <a href="{{ route('themes.edit', $theme->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Edit</a>

                                <!-- Delete Button (Form) -->
                                <form action="{{ route('themes.destroy', $theme->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold" onclick="return confirm('Are you sure you want to delete this theme?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="p-4">
                    {{ $themes->appends(Request::except('page'))->links() }}
                </div>

                @else
                <!-- No Themes Found Message -->
                <div class="text-center py-6">
                    <p class="text-gray-500">No themes found.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>