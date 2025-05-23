<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Projects</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalProjects }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Forum Posts</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $forumPosts->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Network Connections</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $connections->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Quick Stats</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Active Projects -->
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-indigo-100">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Active Projects</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $activeProjects }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Collaborations -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100">
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Total Collaborations</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ auth()->user()->collaborations()->count() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Skills -->
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100">
                                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Skills</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ auth()->user()->skills()->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Projects -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Recent Projects</h2>
                    <div class="space-y-4">
                        @forelse($projects as $project)
                            <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-lg transition">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($project->user->profile_picture_url)
                                            <img src="{{ $project->user->profile_picture_url }}" alt="{{ $project->user->name }}" class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                                                <span class="text-white font-medium">{{ substr($project->user->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $project->title }}</h4>
                                        <p class="text-xs text-gray-500">{{ $project->status }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No projects yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Forum Posts -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Recent Forum Posts</h2>
                    <div class="space-y-4">
                        @forelse($forumPosts as $post)
                            <div class="p-4 hover:bg-gray-50 rounded-lg transition">
                                <h4 class="text-sm font-medium text-gray-900">{{ $post->title }}</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No forum posts yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Connections -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Recent Connections</h2>
                    <div class="space-y-4">
                        @forelse($connections as $project)
                            <div class="flex items-center space-x-4 p-4 hover:bg-gray-50 rounded-lg transition">
                                <div class="flex-shrink-0">
                                    @if($project->user->profile_picture_url)
                                        <img src="{{ $project->user->profile_picture_url }}" alt="{{ $project->user->name }}" class="h-10 w-10 rounded-full object-cover">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                                            <span class="text-white font-medium">{{ substr($project->user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $project->user->name }}</h4>
                                    <p class="text-xs text-gray-500">Collaborating on {{ $project->title }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No connections yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('projects.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-200 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span>New Project</span>
                            </a>
                            <a href="{{ route('forum.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-200 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <span>New Post</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Welcome to Entrepreneurial Network</h3>
                        <div class="space-y-6">
                            <!-- Motivational Quote -->
                            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-6 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-medium text-gray-900 italic">"The best way to predict the future is to create it."</p>
                                        <p class="text-sm text-gray-600 mt-1">- Peter Drucker</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Platform Features -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-start space-x-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Collaborative Projects</h4>
                                        <p class="text-sm text-gray-600 mt-1">Join or create projects with like-minded entrepreneurs</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Global Network</h4>
                                        <p class="text-sm text-gray-600 mt-1">Connect with entrepreneurs from around the world</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Skill Development</h4>
                                        <p class="text-sm text-gray-600 mt-1">Learn and grow through collaborative experiences</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Community Forum</h4>
                                        <p class="text-sm text-gray-600 mt-1">Share ideas and get feedback from the community</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Collaborations Card -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Active Collaborations
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900" id="collaborations-count">
                                    {{ $collaborationsCount }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <div class="text-sm">
                    <a href="{{ route('collaborations.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        View all collaborations
                    </a>
                </div>
            </div>
        </div>

        <!-- Skills Card -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Your Skills
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900" id="skills-count">
                                    {{ $skillsCount }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <div class="text-sm">
                    <a href="{{ route('skills.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        View all skills
                    </a>
                </div>
            </div>
        </div>

        <!-- ... other cards ... -->
    </div>

    <!-- Collaborations List -->
    <div class="mt-8">
        <h2 class="text-lg font-medium text-gray-900">Recent Collaborations</h2>
        <div class="mt-4" id="collaborations-list">
            @foreach($recentCollaborations as $collaboration)
                <div class="mb-4 p-4 bg-white rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold">{{ $collaboration->project->title }}</h3>
                    <p class="text-gray-600">{{ $collaboration->project->description }}</p>
                    <p class="text-sm text-gray-500 mt-2">Status: {{ $collaboration->status }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Skills List -->
    <div class="mt-8">
        <h2 class="text-lg font-medium text-gray-900">Your Skills</h2>
        <div class="mt-4" id="skills-list">
            @foreach($userSkills as $skill)
                <div class="mb-4 p-4 bg-white rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold">{{ $skill->name }}</h3>
                    <p class="text-gray-600">Category: {{ $skill->category }}</p>
                    <p class="text-sm text-gray-500 mt-2">Users with this skill: {{ $skill->users_count }}</p>
                </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
    <script>
        // Add scroll animation
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.animate-on-scroll');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });

            elements.forEach(element => {
                observer.observe(element);
            });
        });

        // Listen for collaboration updates
        Echo.private(`App.Models.User.{{ auth()->id() }}`)
            .listen('CollaborationUpdated', (e) => {
                // Update the collaborations count
                const collaborationsCount = document.getElementById('collaborations-count');
                if (collaborationsCount) {
                    const currentCount = parseInt(collaborationsCount.textContent);
                    collaborationsCount.textContent = currentCount + 1;
                }

                // Add the new collaboration to the list
                const collaborationsList = document.getElementById('collaborations-list');
                if (collaborationsList) {
                    const newCollaboration = document.createElement('div');
                    newCollaboration.className = 'mb-4 p-4 bg-white rounded-lg shadow-sm';
                    newCollaboration.innerHTML = `
                        <h3 class="text-lg font-semibold">${e.project.title}</h3>
                        <p class="text-gray-600">${e.project.description}</p>
                        <p class="text-sm text-gray-500 mt-2">Status: ${e.status}</p>
                    `;
                    collaborationsList.insertBefore(newCollaboration, collaborationsList.firstChild);
                }
            });

        // Listen for skill updates
        Echo.private(`App.Models.User.{{ auth()->id() }}`)
            .listen('SkillUpdated', (e) => {
                // Update the skills count
                const skillsCount = document.getElementById('skills-count');
                if (skillsCount) {
                    const currentCount = parseInt(skillsCount.textContent);
                    skillsCount.textContent = currentCount + 1;
                }

                // Add the new skill to the list
                const skillsList = document.getElementById('skills-list');
                if (skillsList) {
                    const newSkill = document.createElement('div');
                    newSkill.className = 'mb-4 p-4 bg-white rounded-lg shadow-sm';
                    newSkill.innerHTML = `
                        <h3 class="text-lg font-semibold">${e.name}</h3>
                        <p class="text-gray-600">Category: ${e.category}</p>
                        <p class="text-sm text-gray-500 mt-2">Users with this skill: ${e.users_count}</p>
                    `;
                    skillsList.insertBefore(newSkill, skillsList.firstChild);
                }
            });
    </script>
    @endpush
</x-app-layout>
