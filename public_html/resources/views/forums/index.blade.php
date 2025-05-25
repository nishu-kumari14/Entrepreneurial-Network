<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Idea Exchange Forum') }}
            </h2>
            <a href="{{ route('forums.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Post New Idea') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Search and Filter -->
                    <div class="mb-6">
                        <form action="{{ route('forums.index') }}" method="GET" class="flex gap-4">
                            <input type="text" name="search" placeholder="Search ideas..." 
                                   value="{{ request('search') }}"
                                   class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <select name="filter" class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">All Topics</option>
                                <option value="technology" {{ request('filter') == 'technology' ? 'selected' : '' }}>Technology</option>
                                <option value="business" {{ request('filter') == 'business' ? 'selected' : '' }}>Business</option>
                                <option value="marketing" {{ request('filter') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                            </select>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Search
                            </button>
                        </form>
                    </div>

                    <!-- Forum Posts -->
                    <div class="space-y-6">
                        @forelse($forums as $forum)
                            <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-xl font-semibold mb-2">
                                            <a href="{{ route('forums.show', $forum) }}" class="hover:text-blue-600">
                                                {{ $forum->title }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 mb-4">{{ Str::limit($forum->content, 200) }}</p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center">
                                            <form action="{{ route('forums.like', $forum) }}" method="POST" class="flex items-center">
                                                @csrf
                                                <button type="submit" class="flex items-center text-gray-500 hover:text-red-500">
                                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                    </svg>
                                                    <span>{{ $forum->likes_count }}</span>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="flex items-center text-gray-500">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            <span>{{ $forum->comments_count }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center mt-4 text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <img src="{{ $forum->user->profile_image ?? asset('images/default-avatar.png') }}" 
                                             alt="{{ $forum->user->name }}" 
                                             class="w-8 h-8 rounded-full mr-2">
                                        <span>{{ $forum->user->name }}</span>
                                    </div>
                                    <div>
                                        <span>{{ $forum->created_at->diffForHumans() }}</span>
                                        @if($forum->user_id === auth()->id() || auth()->user()->role === 'admin')
                                            <div class="inline-flex ml-4">
                                                <a href="{{ route('forums.edit', $forum) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                                <form action="{{ route('forums.destroy', $forum) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700" 
                                                            onclick="return confirm('Are you sure you want to delete this post?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500">No forum posts found. Be the first to share your idea!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $forums->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 