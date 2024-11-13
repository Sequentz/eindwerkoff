<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Words') }}
            </h2>
            <a href="{{ route('words.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Word
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if(session('success'))
                <div class="mb-4 text-green-500">
                    {{ session('success') }}
                </div>
                @endif

                @if($words->count() > 0)
                <form action="{{ route('words.mass-delete') }}" method="POST" id="mass-delete-form">
                    @csrf
                    @method('DELETE')

                    <table class="w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">
                                    <input type="checkbox" id="select_all" class="select-all-checkbox">
                                </th>
                                <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">ID</th>
                                <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">Word</th>
                                <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">Themes</th>
                                <th class="py-2 px-4 border-b text-center font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($words as $word)
                            <tr>
                                <td class="py-2 px-4 border-b text-center">
                                    <input type="checkbox" name="words[]" value="{{ $word->id }}" class="word-checkbox">
                                </td>
                                <td class="py-2 px-4 border-b text-center">{{ $word->id }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $word->name }}</td>
                                <td class="py-2 px-4 border-b text-center">
                                    @if($word->themes->count() > 1)
                                    <span class="inline-block bg-gray-200 px-2 py-1 text-xs font-semibold text-gray-700 rounded">
                                        {{ $word->themes->count() }} Themes
                                    </span>
                                    @elseif($word->themes->count() === 1)
                                    <span class="inline-block bg-gray-200 px-2 py-1 text-xs font-semibold text-gray-700 rounded">
                                        {{ $word->themes->first()->name }}
                                    </span>
                                    @else
                                    <span class="inline-block bg-gray-200 px-2 py-1 text-xs font-semibold text-gray-700 rounded">
                                        No Themes
                                    </span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b text-center space-x-2">
                                    <a href="{{ route('words.show', $word->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Show</a>
                                    <a href="{{ route('words.edit', $word->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Edit</a>
                                    <button type="button" class="text-red-600 hover:text-red-900 font-bold delete-button" data-word-name="{{ $word->name }}" data-word-id="{{ $word->id }}">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex items-center justify-between p-4">
                        <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" id="delete-selected-button" disabled>
                            Delete Selected Words
                        </button>
                    </div>
                    {{ $words->links() }}
                </form>
                @else
                <div class="text-center py-6">
                    <p class="text-gray-500">No words found.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded shadow-xl">
            <h3 class="text-lg font-bold mb-4" id="modal-title">Are you sure you want to delete these words?</h3>
            <p id="modal-message" class="mb-4">This action cannot be undone.</p>
            <div class="flex justify-end space-x-4">
                <button id="cancel-delete" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded">Cancel</button>
                <button id="confirm-delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
            </div>
        </div>
    </div>

    <script>
        // Select/Deselect All checkboxes
        document.getElementById('select_all').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('.word-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });

            // Enable or disable the mass delete button based on checkbox selection
            var deleteButton = document.getElementById('delete-selected-button');
            var selectedWords = document.querySelectorAll('.word-checkbox:checked');
            deleteButton.disabled = selectedWords.length === 0;
        });

        // Enable the delete button when checkboxes are selected
        document.querySelectorAll('.word-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                var deleteButton = document.getElementById('delete-selected-button');
                var selectedWords = document.querySelectorAll('.word-checkbox:checked');
                deleteButton.disabled = selectedWords.length === 0;
            });
        });

        // Show confirmation modal for individual word deletion
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                var wordName = this.getAttribute('data-word-name');
                var wordId = this.getAttribute('data-word-id');

                // Update modal title and message based on the word being deleted
                document.getElementById('modal-title').textContent = `Are you sure you want to delete "${wordName}"?`;
                document.getElementById('modal-message').textContent = `This action cannot be undone.`;

                // Show the modal
                document.getElementById('confirmation-modal').classList.remove('hidden');

                // Set the form action to the correct delete URL
                document.getElementById('confirm-delete').addEventListener('click', function() {
                    // Submit the form to delete the word
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/words/${wordId}`;
                    var csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);
                    var methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);
                    document.body.appendChild(form);
                    form.submit();
                });
            });
        });

        // Show confirmation modal for mass deletion
        document.getElementById('delete-selected-button').addEventListener('click', function() {
            var selectedWords = document.querySelectorAll('.word-checkbox:checked');
            if (selectedWords.length === 0) {
                alert("No words selected for deletion.");
                return;
            }

            // Update modal title and message for mass deletion
            document.getElementById('modal-title').textContent = `Are you sure you want to delete ${selectedWords.length} word(s)?`;
            document.getElementById('modal-message').textContent = `This action cannot be undone.`;

            // Show the modal
            document.getElementById('confirmation-modal').classList.remove('hidden');

            // Set the form action to the correct mass delete URL
            document.getElementById('confirm-delete').addEventListener('click', function() {
                document.getElementById('mass-delete-form').submit();
            });
        });

        // Hide the modal if the user cancels
        document.getElementById('cancel-delete').addEventListener('click', function() {
            document.getElementById('confirmation-modal').classList.add('hidden');
        });
    </script>

</x-app-layout>