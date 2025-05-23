@props(['post' => null])

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        {{ isset($post) ? 'Edit Post' : 'Create New Post' }}
                    </h2>

                    <form method="POST" 
                          action="{{ isset($post) ? route('forum.update', $post) : route('forum.store') }}" 
                          class="space-y-6">
                        @csrf
                        @if(isset($post))
                            @method('PUT')
                        @endif

                        <div>
                            <x-text-input
                                name="title"
                                label="Title"
                                :value="old('title', $post->title ?? '')"
                                required
                            />
                        </div>

                        <div>
                            <x-select-input
                                name="category_id"
                                label="Category"
                                :options="$categories->pluck('name', 'id')->toArray()"
                                :selected="old('category_id', $post->category_id ?? '')"
                                required
                            />
                        </div>

                        <div>
                            <x-textarea-input
                                name="content"
                                label="Content"
                                :value="old('content', $post->content ?? '')"
                                rows="10"
                                required
                            />
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('forum.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ isset($post) ? 'Update Post' : 'Create Post' }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 