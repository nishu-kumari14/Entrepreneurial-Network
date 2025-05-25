<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Collaborations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="space-y-6">
                        @forelse($collaborations as $collaboration)
                            <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">
                                            <a href="{{ route('projects.show', $collaboration->project) }}" class="hover:text-indigo-600">
                                                {{ $collaboration->project->title }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            Project by {{ $collaboration->project->user->name }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="px-2 py-1 text-xs rounded-full {{ 
                                            $collaboration->status === 'accepted' ? 'bg-green-100 text-green-800' : 
                                            ($collaboration->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') 
                                        }}">
                                            {{ ucfirst($collaboration->status) }}
                                        </span>
                                    </div>
                                </div>
                                @if($collaboration->message)
                                    <p class="mt-2 text-sm text-gray-600">
                                        {{ $collaboration->message }}
                                    </p>
                                @endif
                                <div class="mt-4 text-sm text-gray-500">
                                    Requested {{ $collaboration->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">
                                You don't have any collaborations yet.
                            </p>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $collaborations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 