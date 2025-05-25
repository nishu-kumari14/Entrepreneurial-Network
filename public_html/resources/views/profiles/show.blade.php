<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="h-32 w-32 rounded-full object-cover" 
                                 src="{{ $user->profile_image ? Storage::url($user->profile_image) : asset('images/default-avatar.png') }}" 
                                 alt="{{ $user->name }}">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h2 class="text-2xl font-bold text-gray-900 truncate">{{ $user->name }}</h2>
                            <p class="text-sm text-gray-500">{{ $user->role }}</p>
                            @if($user->company)
                                <p class="text-sm text-gray-600">{{ $user->company }}</p>
                            @endif
                            @if($user->location)
                                <p class="text-sm text-gray-600">{{ $user->location }}</p>
                            @endif
                        </div>
                        @if(Auth::id() === $user->id)
                            <div>
                                <a href="{{ route('profiles.edit') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    Edit Profile
                                </a>
                            </div>
                        @endif
                    </div>

                    @if($user->bio)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">About</h3>
                            <p class="mt-2 text-gray-600">{{ $user->bio }}</p>
                        </div>
                    @endif

                    @if($user->skills)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">Skills</h3>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach($user->skills as $skill)
                                    <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($user->interests)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">Interests</h3>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach($user->interests as $interest)
                                    <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                        {{ $interest }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900">Social Links</h3>
                        <div class="mt-2 flex space-x-4">
                            @if($user->website)
                                <a href="{{ $user->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                    Website
                                </a>
                            @endif
                            @if($user->linkedin)
                                <a href="{{ $user->linkedin }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                    LinkedIn
                                </a>
                            @endif
                            @if($user->twitter)
                                <a href="{{ $user->twitter }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                    Twitter
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900">Projects</h3>
                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @forelse($user->projects as $project)
                                <div class="bg-white overflow-hidden shadow rounded-lg">
                                    <div class="p-4">
                                        <h4 class="text-lg font-medium text-gray-900">{{ $project->title }}</h4>
                                        <p class="mt-2 text-sm text-gray-600">{{ Str::limit($project->description, 100) }}</p>
                                        <div class="mt-4 flex items-center justify-between">
                                            <span class="px-2 py-1 text-xs rounded-full {{ $project->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($project->status) }}
                                            </span>
                                            <a href="{{ route('projects.show', $project) }}" 
                                               class="text-sm text-blue-600 hover:text-blue-800">
                                                View Project
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">No projects yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900">Collaborations</h3>
                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @forelse($user->collaborations as $collaboration)
                                <div class="bg-white overflow-hidden shadow rounded-lg">
                                    <div class="p-4">
                                        <h4 class="text-lg font-medium text-gray-900">{{ $collaboration->project->title }}</h4>
                                        <p class="mt-2 text-sm text-gray-600">{{ Str::limit($collaboration->project->description, 100) }}</p>
                                        <div class="mt-4 flex items-center justify-between">
                                            <span class="px-2 py-1 text-xs rounded-full {{ $collaboration->status === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($collaboration->status) }}
                                            </span>
                                            <a href="{{ route('projects.show', $collaboration->project) }}" 
                                               class="text-sm text-blue-600 hover:text-blue-800">
                                                View Project
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">No collaborations yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 