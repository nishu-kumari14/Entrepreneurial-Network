<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Search Results for "{{ $query }}"
            </h2>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(count($results['projects']) > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Projects</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($results['projects'] as $project)
                                    <div class="border rounded-lg p-4">
                                        <h4 class="font-semibold">{{ $project->title }}</h4>
                                        <p class="text-sm text-gray-600">{{ Str::limit($project->description, 100) }}</p>
                                        <div class="mt-2">
                                            <span class="text-sm text-gray-500">By: {{ $project->user->name }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(count($results['users']) > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Users</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($results['users'] as $user)
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center">
                                            <img src="{{ $user->profile_picture_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                                            <div class="ml-3">
                                                <h4 class="font-semibold">{{ $user->name }}</h4>
                                                <p class="text-sm text-gray-600">{{ $user->role }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(count($results['forum_posts']) > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Forum Posts</h3>
                            <div class="space-y-4">
                                @foreach($results['forum_posts'] as $post)
                                    <div class="border rounded-lg p-4">
                                        <h4 class="font-semibold">{{ $post->title }}</h4>
                                        <p class="text-sm text-gray-600">{{ Str::limit($post->content, 150) }}</p>
                                        <div class="mt-2 flex justify-between items-center">
                                            <span class="text-sm text-gray-500">By: {{ $post->user->name }}</span>
                                            <span class="text-sm text-gray-500">Category: {{ $post->category->name }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(count($results['projects']) === 0 && count($results['users']) === 0 && count($results['forum_posts']) === 0)
                        <div class="text-center py-8">
                            <p class="text-gray-500">No results found for "{{ $query }}"</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 