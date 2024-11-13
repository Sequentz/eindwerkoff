<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Themes') }}
            </h2>
            <a href="{{ route('themes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Theme
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if(session('success'))
                <div class="bg-green-500 text-white p-4 mb-4 rounded">
                    {{ session('success') }}
                </div>
                @elseif(session('error'))
                <div class="bg-red-500 text-white p-4 mb-4 rounded">
                    {{ session('error') }}
                </div>
                @endif

                <form method="GET" action="{{ route('themes.index') }}" class="mb-4">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search themes..." class="border border-gray-300 p-2 rounded">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Search</button>
                </form>

                @if($themes->count() > 0)
                <form action="{{ route('themes.mass-delete') }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <table class="w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">
                                    <input type="checkbox" id="select_all_themes" class="select-all-checkbox">
                                </th>
                                <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">ID</th>
                                <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">Theme</th>
                                <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($themes as $theme)
                            <tr>
                                <td class="py-2 px-4 border-b text-center">
                                    <input type="checkbox" name="themes[]" value="{{ $theme->id }}" class="theme-checkbox">
                                </td>
                                <td class="py-2 px-4 border-b text-center">{{ $theme->id }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $theme->name }}</td>
                                <td class="py-2 px-4 border-b text-center space-x-2">
                                    <a href="{{ route('themes.show', $theme->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Show</a>
                                    <a href="{{ route('themes.edit', $theme->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Edit</a>
                                    <form action="{{ route('themes.destroy', $theme->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex items-center justify-between p-4">
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                            onclick="return confirm('Are you sure you want to delete selected themes?')">
                            Delete Selected Themes
                        </button>
                    </div>
                    {{ $themes->links() }}
                </form>
                @else
                <div class="text-center py-6">
                    <p class="text-gray-500">No themes found.</p>
                    <a href="{{ route('themes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add Theme
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        const selectAllCheckbox = document.getElementById('select_all_themes');
        const themeCheckboxes = document.querySelectorAll('.theme-checkbox');

        selectAllCheckbox.addEventListener('change', function() {
            themeCheckboxes.forEach(checkbox => checkbox.checked = this.checked);
        });

        themeCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                selectAllCheckbox.checked = Array.from(themeCheckboxes).every(cb => cb.checked);
            });
        });
    </script>
</x-app-layout>