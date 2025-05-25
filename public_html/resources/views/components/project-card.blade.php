@props(['project'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">
                    <a href="{{ route('projects.show', $project) }}" class="hover:text-indigo-600">
                        {{ $project->title }}
                    </a>
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ Str::limit($project->description, 100) }}
                </p>
            </div>
            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                {{ $project->status === 'active' ? 'bg-green-100 text-green-800' : 
                   ($project->status === 'completed' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                {{ ucfirst($project->status) }}
            </span>
        </div>

        <div class="mt-4">
            <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ $project->created_at->diffForHumans() }}
            </div>

            @if($project->skills->count() > 0)
                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach($project->skills as $skill)
                        <span class="px-2 py-1 text-xs font-medium text-indigo-600 bg-indigo-100 rounded-full">
                            {{ $skill->name }}
                        </span>
                    @endforeach
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    @if($project->user->profile_picture_url)
                        <img src="{{ $project->user->profile_picture_url }}" alt="{{ $project->user->name }}" class="h-8 w-8 rounded-full object-cover">
                    @else
                        <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center">
                            <span class="text-white font-medium text-sm">{{ substr($project->user->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $project->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $project->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <span class="text-sm text-gray-500">
                    {{ $project->collaborators_count }} {{ __('collaborators') }}
                </span>
            </div>
        </div>
    </div>
</div> 