<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Find Users to Message
            </h2>
            <a href="{{ route('messages.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Back to Messages
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
                                   value="{{ request('query') }}"
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                   placeholder="Search users by name or email..."
                                   required
                                   autofocus>
                            <button type="submit" 
                                    class="ml-3 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Search
                            </button>
                        </div>
                    </form>

                    @if(request()->has('query'))
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                Search results for "{{ request('query') }}"
                            </h3>
                            <p class="text-sm text-gray-500">
                                {{ $users->count() }} {{ Str::plural('user', $users->count()) }} found
                            </p>
                        </div>

                        @if($users->isEmpty())
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
                                <p class="mt-1 text-sm text-gray-500">Try searching with a different name or email.</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($users as $user)
                                    <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex items-center">
                                            <img src="{{ $user->profile_picture_url }}" 
                                                 alt="{{ $user->name }}"
                                                 class="h-12 w-12 rounded-full">
                                            <div class="ml-4">
                                                <h3 class="text-sm font-medium text-gray-900">{{ $user->name }}</h3>
                                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                                @if($user->bio)
                                                    <p class="text-sm text-gray-500 mt-1">{{ Str::limit($user->bio, 100) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('profiles.show', $user) }}" 
                                               class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                View Profile
                                            </a>
                                            <a href="{{ route('messages.show', $user) }}" 
                                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Message
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6">
                                {{ $users->appends(['query' => request('query')])->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Search for users</h3>
                            <p class="mt-1 text-sm text-gray-500">Enter a name or email to find users to message.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 