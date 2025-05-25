            <div class="flex items-center space-x-3">
                @if($post->user->profile_picture_url)
                    <img src="{{ $post->user->profile_picture_url }}" alt="{{ $post->user->name }}" class="h-8 w-8 rounded-full object-cover">
                @else
                    <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center">
                        <span class="text-white font-medium text-sm">{{ substr($post->user->name, 0, 1) }}</span>
                    </div>
                @endif
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $post->user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div> 