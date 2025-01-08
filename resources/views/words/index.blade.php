<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Words') }}
            </h2>
            <a href="{{ route('words.create') }}" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                Add Word
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">

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
                                <th class="px-4 py-2 font-semibold text-center text-gray-600 border-b">
                                    <input type="checkbox" id="select_all" class="select-all-checkbox">
                                </th>
                                <th class="px-4 py-2 font-semibold text-center text-gray-600 border-b">ID</th>
                                <th class="px-4 py-2 font-semibold text-center text-gray-600 border-b">Word</th>
                                <th class="px-4 py-2 font-semibold text-center text-gray-600 border-b">Themes</th>
                                <th class="px-4 py-2 font-semibold text-center text-gray-600 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($words as $word)
                            <tr>
                                <td class="px-4 py-2 text-center border-b">
                                    <input type="checkbox" name="words[]" value="{{ $word->id }}" class="word-checkbox">
                                </td>
                                <td class="px-4 py-2 text-center border-b">{{ $word->id }}</td>
                                <td class="px-4 py-2 text-center border-b">{{ $word->name }}</td>
                                <td class="px-4 py-2 text-center border-b">
                                    @if($word->themes->count() > 1)
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-200 rounded">
                                        {{ $word->themes->count() }} Themes
                                    </span>
                                    @elseif($word->themes->count() === 1)
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-200 rounded">
                                        {{ $word->themes->first()->name }}
                                    </span>
                                    @else
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-200 rounded">
                                        No Themes
                                    </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 space-x-2 text-center border-b">
                                    <a href="{{ route('words.show', $word->id) }}" class="font-bold text-indigo-600 hover:text-indigo-900">Show</a>
                                    <a href="{{ route('words.edit', $word->id) }}" class="font-bold text-blue-600 hover:text-blue-900">Edit</a>
                                    <button type="button" class="font-bold text-red-600 hover:text-red-900 delete-button" data-word-name="{{ $word->name }}" data-word-id="{{ $word->id }}">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex items-center justify-between p-4">
                        <button type="button" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700 focus:outline-none focus:shadow-outline" id="delete-selected-button" disabled>
                            Delete Selected Words
                        </button>
                    </div>
                    {{ $words->links() }}
                </form>
                @else
                <div class="py-6 text-center">
                    <p class="text-gray-500">No words found.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50">
        <div class="p-6 bg-white rounded shadow-xl">
            <h3 class="mb-4 text-lg font-bold" id="modal-title">Are you sure you want to delete these words?</h3>
            <p id="modal-message" class="mb-4">This action cannot be undone.</p>
            <div class="flex justify-end space-x-4">
                <button id="cancel-delete" class="px-4 py-2 text-gray-800 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                <button id="confirm-delete" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Delete</button>
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