<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Theme Details: ') }} {{ $theme->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-bold">Words Associated with this Theme:</h3>

                @if ($theme->words->count() > 0)
                <ul class="mt-4">
                    @foreach ($theme->words as $word)
                    <li class="py-2 px-4 border-b">{{ $word->name }}</li>
                    @endforeach
                </ul>
                @else
                <p class="text-gray-500">No words associated with this theme.</p>
                @endif

                <div class="mt-6">
                    <a href="{{ route('themes.index') }}" class="text-blue-500 hover:text-blue-800">Back to Themes List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>