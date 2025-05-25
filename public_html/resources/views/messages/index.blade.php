<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Messages') }}
            </h2>
            <a href="{{ route('messages.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                {{ __('New Message') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($conversations->isEmpty())
                        <p class="text-gray-600 text-center py-8">
                            {{ __('No messages yet. Start a conversation with someone!') }}
                        </p>
                    @else
                        <div class="space-y-4">
                            @foreach($conversations as $conversation)
                                <a href="{{ route('messages.show', ['user' => $conversation['user']->id]) }}" 
                                   class="block hover:bg-gray-50 p-4 rounded-lg border {{ $conversation['unread_count'] > 0 ? 'border-indigo-500' : 'border-gray-200' }}">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <img class="h-10 w-10 rounded-full" 
                                                     src="{{ $conversation['user']->profile_picture_url }}" 
                                                     alt="{{ $conversation['user']->name }}"
                                                     onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">
                                                    {{ $conversation['user']->name }}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate">
                                                    {{ $conversation['last_message']->content }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <div class="text-sm text-gray-500">
                                                {{ $conversation['last_message']->created_at->diffForHumans() }}
                                            </div>
                                            @if($conversation['unread_count'] > 0)
                                                <div class="bg-indigo-100 text-indigo-600 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                    {{ $conversation['unread_count'] }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 