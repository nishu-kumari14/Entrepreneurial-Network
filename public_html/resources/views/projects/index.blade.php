<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Projects') }}
            </h2>
            @auth
                <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Create New Project') }}
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('projects.index') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Search by Title -->
                            <div>
                                <x-input-label for="search" :value="__('Search Projects')" />
                                <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" 
                                    :value="request('search')" placeholder="{{ __('Search by title...') }}" />
                            </div>

                            <!-- Filter by Skills -->
                            <div>
                                <x-input-label for="skills" :value="__('Filter by Skills')" />
                                <x-text-input id="skills" name="skills" type="text" class="mt-1 block w-full" 
                                    :value="request('skills')" placeholder="{{ __('Enter skills (comma-separated)') }}" />
                            </div>

                            <!-- Filter by Status -->
                            <div class="w-full md:w-48">
                                <select name="status" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="on_hold" {{ request('status') === 'on_hold' ? 'selected' : '' }}>On Hold</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <x-primary-button>
                                {{ __('Apply Filters') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="mb-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('projects.index') }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ request('status') === null ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                            All Projects
                        </a>
                        <a href="{{ route('projects.index', ['status' => 'active']) }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ request('status') === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                            Active
                        </a>
                        <a href="{{ route('projects.index', ['status' => 'completed']) }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ request('status') === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                            Completed
                        </a>
                        <a href="{{ route('projects.index', ['status' => 'on_hold']) }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ request('status') === 'on_hold' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                            On Hold
                        </a>
                    </div>
                </div>
            </div>

            <!-- Projects Grid -->
            @if($projects->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($projects as $project)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        <a href="{{ route('projects.show', $project) }}" class="hover:text-indigo-600 transition-colors duration-200">
                                            {{ $project->title }}
                                        </a>
                                    </h3>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                                        {{ $project->status === 'active' ? 'bg-green-100 text-green-800' : 
                                           ($project->status === 'completed' ? 'bg-blue-100 text-blue-800' : 
                                           ($project->status === 'on_hold' ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                </div>
                                
                                <p class="text-gray-600 mb-4 line-clamp-3">{{ $project->description }}</p>
                                
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach($project->skills_required as $skill)
                                        <span class="px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 rounded-full">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                                
                                <div class="flex justify-between items-center text-sm text-gray-500">
                                    <span>Created {{ $project->created_at->diffForHumans() }}</span>
                                    <span>{{ $project->collaborators_count }} collaborators</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $projects->links() }}
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-gray-500">{{ __('No projects found.') }}</p>
                        @if(request()->hasAny(['search', 'skills', 'status']))
                            <a href="{{ route('projects.index') }}" class="mt-4 inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                {{ __('Clear filters') }}
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 