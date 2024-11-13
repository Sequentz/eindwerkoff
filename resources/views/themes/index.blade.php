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

    <div class="py-12 page-content">
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
                <form id="mass-delete-form" action="{{ route('themes.mass-delete') }}" method="POST">
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
                                    <input type="checkbox" name="themes[]" value="{{ $theme->id }}" data-name="{{ $theme->name }}" class="theme-checkbox">
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
                        <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                            onclick="showDeleteModal()">
                            Delete Selected Themes
                        </button>
                    </div>
                    {{ $themes->links() }}
                </form>
                @else
                <div class="text-center py-6">
                    <p class="text-gray-500">No themes found.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="absolute inset-0 bg-gray-900 opacity-50 backdrop-blur-sm"></div>
        <div class="relative bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
            <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
            <p class="text-gray-600 mb-6">
                Are you sure you want to delete the selected themes:
                <span id="selectedThemes" class="font-semibold text-red-500"></span>?
            </p>
            <div class="flex justify-end space-x-4">
                <button onclick="hideDeleteModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Cancel
                </button>
                <button onclick="confirmMassDelete()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <style>
        /* Blur effect for page content when modal is open */
        .blur {
            filter: blur(5px);
        }
    </style>

    <script>
        const selectAllCheckbox = document.getElementById('select_all_themes');
        const themeCheckboxes = document.querySelectorAll('.theme-checkbox');
        const pageContent = document.querySelector('.page-content');

        // Toggle Select All
        selectAllCheckbox.addEventListener('change', function() {
            themeCheckboxes.forEach(checkbox => checkbox.checked = this.checked);
        });

        // Collect selected theme names and show modal
        function showDeleteModal() {
            const selectedNames = Array.from(themeCheckboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.getAttribute('data-name'));

            if (selectedNames.length === 0) {
                alert("Please select at least one theme to delete.");
                return;
            }

            document.getElementById('selectedThemes').textContent = selectedNames.join(', ');
            document.getElementById('deleteModal').classList.remove('hidden');
            pageContent.classList.add('blur');
        }

        // Hide modal and remove blur
        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            pageContent.classList.remove('blur');
        }

        // Confirm deletion and submit the form
        function confirmMassDelete() {
            document.getElementById('mass-delete-form').submit();
        }
    </script>
</x-app-layout>