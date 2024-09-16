<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Conflicting Emotions') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                        {{ __('Summary') }}
                    </h2>
                    <div class="text-gray-900 dark:text-gray-100">
                        @if ($diaryEntries->isEmpty())
                            <p class="text-center">{{ __('No conflicting emotions found.') }}</p>
                        @else 
                            <table class="min-w-full bg-white dark:bg-gray-800 shadow-md rounded-lg">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr class="text-left border-b border-gray-200 dark:border-gray-600">
                                        <th class="px-4 py-2">{{ __('ID') }}</th>
                                        <th class="px-4 py-2">{{ __('Date') }}</th>
                                        <th class="px-4 py-2">{{ __('Content') }}</th>
                                        <th class="px-4 py-2">{{ __('Emotion') }}</th>
                                        <th class="px-4 py-2">{{ __('Intensity') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($diaryEntries as $entry)
                                        <tr class="border-b border-gray-200 dark:border-gray-600">
                                            <td class="px-4 py-2">{{ $entry->id }}</td>
                                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($entry->date)->format('M d, Y') }}</td>
                                            <td class="px-4 py-2">{{ $entry->content }}</td>
                                            <td class="px-4 py-2">{{ $entry->emotion_name }}</td> 
                                            <td class="px-4 py-2">{{ $entry->intensity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif 
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>