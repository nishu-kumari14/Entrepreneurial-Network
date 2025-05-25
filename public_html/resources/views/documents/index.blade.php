<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Project Documents') }} - {{ $project->name }}
            </h2>
            <a href="{{ route('projects.documents.create', $project) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                {{ __('New Document') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($documents->isEmpty())
                        <div class="text-center py-8">
                            <h3 class="text-lg font-medium text-gray-500">
                                {{ __('No documents yet') }}
                            </h3>
                            <p class="mt-2 text-sm text-gray-400">
                                {{ __('Create your first document to start collaborating with your team.') }}
                            </p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($documents as $document)
                                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="text-lg font-medium">
                                                <a href="{{ route('projects.documents.show', [$project, $document]) }}" class="text-indigo-600 hover:text-indigo-800">
                                                    {{ $document->title }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ __('Type:') }} {{ ucfirst($document->type) }}
                                            </p>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $document->current_editors ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $document->current_editors ? count($document->current_editors) . ' editing' : 'No editors' }}
                                        </span>
                                    </div>
                                    <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                                        <div>
                                            {{ __('Last updated:') }} {{ $document->updated_at->diffForHumans() }}
                                        </div>
                                        <form action="{{ route('projects.documents.destroy', [$project, $document]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this document?')">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $documents->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 