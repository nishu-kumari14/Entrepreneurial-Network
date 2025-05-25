<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Forum Discussion') }}
            </h2>
            <a href="{{ route('forums.index') }}" class="text-blue-500 hover:text-blue-700">
                {{ __('Back to Forum') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Forum Post -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-2xl font-bold mb-4">{{ $forum->title }}</h1>
                            <p class="text-gray-700 whitespace-pre-line">{{ $forum->content }}</p>
                        </div>
                        <div class="flex items-center space-x-4">
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
                    </div>

                    <div class="flex justify-between items-center mt-4 text-sm text-gray-500">
                        <div class="flex items-center">
                            <img src="{{ $forum->user->profile_picture_url }}" 
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
            </div>

            <!-- Comments Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Comments ({{ $forum->comments_count }})</h3>

                    <!-- Comment Form -->
                    <form action="{{ route('forums.comments.store', $forum) }}" method="POST" class="mb-6">
                        @csrf
                        <div class="mb-4">
                            <textarea name="comment" rows="3" 
                                      class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                      placeholder="Share your thoughts..."></textarea>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Post Comment
                        </button>
                    </form>

                    <!-- Comments List -->
                    <div class="space-y-4">
                        @forelse($forum->comments as $comment)
                            <div class="border-b pb-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <img src="{{ $comment->user->profile_picture_url }}" 
                                                 alt="{{ $comment->user->name }}" 
                                                 class="w-6 h-6 rounded-full mr-2">
                                            <span class="font-medium">{{ $comment->user->name }}</span>
                                            <span class="text-gray-500 text-sm ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-700">{{ $comment->comment }}</p>
                                    </div>
                                    @if($comment->user_id === auth()->id() || auth()->user()->role === 'admin')
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700" 
                                                    onclick="return confirm('Are you sure you want to delete this comment?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">No comments yet. Be the first to comment!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 