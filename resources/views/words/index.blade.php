<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Words') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">
                                @sortablelink('id', 'ID')
                            </th>
                            <th class="py-2 px-4 border-b">
                                @sortablelink('word', 'word')
                            </th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($words as $word)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $word->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $word->name }}</td>
                            <td class="py-2 px-4 border-b">
                                <!-- Add actions like Edit/Delete if needed -->
                                <a href="{{ route('words.edit', $word->id) }}" class="text-blue-500">Edit</a>
                                |
                                <form action="{{ route('words.destroy', $word->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-4">
                    {{ $words->appends(Request::except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>