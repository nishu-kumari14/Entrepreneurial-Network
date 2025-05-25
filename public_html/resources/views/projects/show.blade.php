<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Project Details') }}
            </h2>
            <div class="flex space-x-4">
                @can('update', $project)
                    <a href="{{ route('projects.edit', $project) }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-105">
                        {{ __('Edit Project') }}
                    </a>
                @endcan
                @can('delete', $project)
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-105" 
                                onclick="return confirm('Are you sure you want to delete this project?')">
                            {{ __('Delete Project') }}
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Project Details Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8 transform transition duration-500 hover:shadow-xl">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div class="space-y-4">
                            <div class="relative">
                                <h1 class="text-3xl font-bold text-gray-900 mb-2 animate-fade-in" style="opacity: 1; visibility: visible; transform: none;">
                                    {{ $project->title }}
                                </h1>
                            </div>
                            <div class="flex items-center space-x-3 group">
                                <div class="relative">
                                    @if($project->user->profile_picture_url)
                                        <img src="{{ $project->user->profile_picture_url }}" 
                                             alt="{{ $project->user->name }}" 
                                             class="h-12 w-12 rounded-full object-cover transform transition duration-300 group-hover:scale-110">
                                    @else
                                        <div class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center transform transition duration-300 group-hover:scale-110">
                                            <span class="text-white font-medium text-lg">{{ substr($project->user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $project->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $project->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                        <span class="px-4 py-2 text-sm font-medium rounded-full transform transition duration-300 hover:scale-105
                            {{ $project->status === 'active' ? 'bg-green-100 text-green-800' : 
                               ($project->status === 'completed' ? 'bg-blue-100 text-blue-800' : 
                               ($project->status === 'on_hold' ? 'bg-yellow-100 text-yellow-800' : 
                               'bg-red-100 text-red-800')) }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </div>

                    <div class="prose max-w-none mb-8 animate-fade-in-up">
                        {!! nl2br(e($project->description)) !!}
                    </div>

                    <div class="mb-8 animate-fade-in-up">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Required Skills</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($project->skills_required as $skill)
                                <span class="px-4 py-2 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium transform transition duration-300 hover:scale-105 hover:bg-indigo-200">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-8 animate-fade-in-up">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Project Timeline</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg transform transition duration-300 hover:scale-105">
                                <p class="text-sm text-gray-500">Start Date</p>
                                <p class="font-medium text-lg">{{ $project->start_date->format('F j, Y') }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg transform transition duration-300 hover:scale-105">
                                <p class="text-sm text-gray-500">End Date</p>
                                <p class="font-medium text-lg">{{ $project->end_date->format('F j, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 animate-fade-in-up">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Collaborators') }}</h3>
                        @if($project->collaborators->count() > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                                @foreach($project->collaborators as $collaborator)
                                    <div class="flex flex-col items-center p-6 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                        <div class="relative group">
                                            <img src="{{ $collaborator->profile_picture_url }}" 
                                                 alt="{{ $collaborator->name }}" 
                                                 class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg transform transition duration-300 group-hover:scale-110"
                                                 onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                            @if($collaborator->pivot->role)
                                                <span class="absolute -bottom-1 -right-1 bg-indigo-100 text-indigo-800 text-xs px-3 py-1 rounded-full transform transition duration-300 group-hover:scale-110">
                                                    {{ $collaborator->pivot->role }}
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 text-center mt-4">{{ $collaborator->name }}</span>
                                        <div class="flex space-x-2 mt-4">
                                            <a href="{{ route('messages.create', ['user' => $collaborator->id]) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-105">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                                </svg>
                                                {{ __('Message') }}
                                            </a>
                                            @if($isOwner)
                                                <form action="{{ route('projects.remove-collaborator', [$project, $collaborator]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-105"
                                                            onclick="return confirm('Are you sure you want to remove this collaborator?')">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        {{ __('Remove') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 bg-gray-50 rounded-lg">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('No collaborators yet') }}</h3>
                                <p class="mt-1 text-sm text-gray-500">{{ __('Get started by inviting collaborators to your project.') }}</p>
                            </div>
                        @endif

                        @if(!$isOwner && !$isCollaborator && !$hasPendingRequest)
                            <div class="mt-8 animate-fade-in-up">
                                <form action="{{ route('projects.collaborate', $project) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div class="bg-gray-50 p-6 rounded-lg">
                                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Why do you want to collaborate on this project?') }}</label>
                                        <textarea name="message" 
                                                  id="message"
                                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                  rows="3"
                                                  placeholder="{{ __('Share your motivation and skills...') }}"></textarea>
                                        <button type="submit" 
                                                class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-105">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            {{ __('Request to Collaborate') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @elseif($hasPendingRequest)
                            <div class="mt-8 p-4 bg-yellow-50 rounded-lg animate-fade-in-up">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <p class="text-yellow-700">{{ __('You have a pending collaboration request for this project.') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($isOwner && $project->collaborationRequests->count() > 0)
                            <div class="mt-8 animate-fade-in-up">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Pending Collaboration Requests') }}</h3>
                                <div class="space-y-4">
                                    @foreach($project->collaborationRequests as $request)
                                        <div class="bg-white p-6 rounded-lg shadow-sm transform transition duration-300 hover:scale-105 hover:shadow-md">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-4">
                                                    <div class="relative">
                                                        <img src="{{ $request->user->profile_picture_url }}" 
                                                             alt="{{ $request->user->name }}" 
                                                             class="w-12 h-12 rounded-full object-cover transform transition duration-300 hover:scale-110"
                                                             onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-gray-900">{{ $request->user->name }}</p>
                                                        @if($request->message)
                                                            <p class="text-sm text-gray-600 mt-1">{{ $request->message }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex space-x-3">
                                                    <form action="{{ route('projects.manage-collaboration', $project) }}" method="POST" class="flex flex-col space-y-3">
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{ $request->user->id }}">
                                                        <input type="hidden" name="action" value="accept">
                                                        <textarea name="welcome_message" 
                                                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                                  rows="2"
                                                                  placeholder="{{ __('Add a welcome message (optional)') }}"></textarea>
                                                        <button type="submit" 
                                                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-105">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                            {{ __('Accept') }}
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('projects.manage-collaboration', $project) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{ $request->user->id }}">
                                                        <input type="hidden" name="action" value="reject">
                                                        <button type="submit" 
                                                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-105">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                            {{ __('Reject') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(10px); 
                visibility: hidden;
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
                visibility: visible;
            }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
        }
        
        .animate-fade-in-up {
            animation: fadeIn 0.5s ease-out 0.2s forwards;
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
        }

        /* Ensure elements maintain their final state after animation */
        .animate-fade-in,
        .animate-fade-in-up {
            animation-fill-mode: forwards;
            will-change: transform, opacity, visibility;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            transform: translateZ(0);
            -webkit-transform: translateZ(0);
        }

        /* Add a subtle hover effect to project title */
        h1.animate-fade-in {
            transition: transform 0.3s ease;
            position: relative;
            z-index: 1;
        }

        h1.animate-fade-in:hover {
            transform: scale(1.02);
        }

        /* Force visibility after animation */
        @media (prefers-reduced-motion: no-preference) {
            .animate-fade-in,
            .animate-fade-in-up {
                animation: fadeIn 0.5s ease-out forwards;
            }
        }

        /* Fallback for reduced motion */
        @media (prefers-reduced-motion: reduce) {
            .animate-fade-in,
            .animate-fade-in-up {
                animation: none;
                opacity: 1 !important;
                visibility: visible !important;
                transform: none !important;
            }
        }
    </style>
</x-app-layout> 