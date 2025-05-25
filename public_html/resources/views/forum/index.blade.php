<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Forum') }}
            </h2>
            <a href="{{ route('forum.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                {{ __('New Post') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Categories Sidebar -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Categories</h3>
                            <div class="space-y-2">
                                @foreach($categories as $category)
                                    <a href="{{ route('forum.category', $category) }}" class="block p-2 hover:bg-gray-50 rounded-md">
                                        <div class="flex justify-between items-center">
                                            <span>{{ $category->name }}</span>
                                            <span class="text-sm text-gray-500">{{ $category->posts_count }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Latest Posts -->
                <div class="md:col-span-3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Latest Posts</h3>
                            <div class="space-y-4">
                                @forelse($latestPosts as $post)
                                    <div class="border-b pb-4 last:border-b-0 last:pb-0">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <a href="{{ route('forum.show', $post) }}" class="text-lg font-medium hover:text-blue-600">
                                                    {{ $post->title }}
                                                </a>
                                                <div class="text-sm text-gray-500 mt-1">
                                                    Posted by {{ $post->user->name }} in {{ $post->category->name }}
                                                    · {{ $post->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <span>{{ $post->comments_count ?? 0 }} comments</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No posts found.</p>
                                @endforelse
                            </div>

                            <div class="mt-6">
                                {{ $latestPosts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 