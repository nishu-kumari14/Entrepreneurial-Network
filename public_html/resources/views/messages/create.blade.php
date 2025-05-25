<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('New Message') }}
            </h2>
            <a href="{{ route('messages.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Back to Messages') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('messages.search') }}" method="GET" class="mb-6">
                        <div class="flex items-center">
                            <input type="text" 
                                   name="query" 
                                   value="{{ $query ?? '' }}"
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   placeholder="{{ __('Search users by name or email...') }}"
                                   required>
                            <button type="submit" 
                                    class="ml-3 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Search') }}
                            </button>
                        </div>
                    </form>

                    @if(isset($users))
                        @if($users->isEmpty())
                            <p class="text-gray-500 text-center py-4">
                                {{ __('No users found matching your search.') }}
                            </p>
                        @else
                            <div class="space-y-4">
                                @foreach($users as $user)
                                    <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex items-center">
                                            <img src="{{ $user->profile_picture_url }}" 
                                                 alt="{{ $user->name }}"
                                                 class="h-10 w-10 rounded-full object-cover"
                                                 onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                            <div class="ml-4">
                                                <h3 class="text-sm font-medium text-gray-900">{{ $user->name }}</h3>
                                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('messages.show', $user) }}" 
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            {{ __('Message') }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <p class="mt-2">{{ __('Search for users to start a conversation') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 