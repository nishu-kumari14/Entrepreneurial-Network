<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $document->title }}
            </h2>
            <div class="flex items-center space-x-4">
                <span id="editor-count" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    {{ count($document->current_editors) }} {{ Str::plural('editor', count($document->current_editors)) }}
                </span>
                <a href="{{ route('projects.documents.index', $project) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    {{ __('Back to Documents') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <div id="editor-list" class="flex items-center space-x-2 text-sm text-gray-500">
                            <span>{{ __('Currently editing:') }}</span>
                            <div class="flex -space-x-2">
                                @foreach($document->current_editors ?? [] as $editorId)
                                    @php $editor = \App\Models\User::find($editorId) @endphp
                                    @if($editor)
                                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" 
                                             src="{{ $editor->profile_picture_url }}" 
                                             alt="{{ $editor->name }}"
                                             title="{{ $editor->name }}">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @if($document->type === 'code')
                        <div class="relative">
                            <textarea id="content" 
                                    class="block w-full rounded-md border-gray-300 bg-gray-100 font-mono text-sm leading-5 focus:border-indigo-500 focus:ring-indigo-500"
                                    rows="20"
                                    spellcheck="false">{{ $document->content }}</textarea>
                        </div>
                    @elseif($document->type === 'diagram')
                        <div class="relative">
                            <div id="diagram-container" class="border rounded-md p-4 min-h-[400px]">
                                {{ $document->content }}
                            </div>
                        </div>
                    @else
                        <div class="relative">
                            <textarea id="content" 
                                    class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                    rows="20">{{ $document->content }}</textarea>
                        </div>
                    @endif

                    <div class="mt-4 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            {{ __('Last updated') }}: <span id="last-updated">{{ $document->updated_at->diffForHumans() }}</span>
                        </div>
                        <div id="save-status" class="text-sm text-gray-500">
                            {{ __('All changes saved') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            encrypted: true
        });

        const channel = pusher.subscribe('presence-document.{{ $document->id }}');
        const content = document.getElementById('content');
        const saveStatus = document.getElementById('save-status');
        const editorCount = document.getElementById('editor-count');
        const editorList = document.getElementById('editor-list');
        let typingTimer;

        // Handle real-time updates
        channel.bind('document-updated', function(data) {
            if (data.user.id !== {{ auth()->id() }}) {
                content.value = data.content;
                document.getElementById('last-updated').textContent = 'just now';
                
                // Update editor count and list
                updateEditorList(data.document_id);
            }
        });

        // Handle content changes
        content.addEventListener('input', function() {
            saveStatus.textContent = 'Saving...';
            clearTimeout(typingTimer);
            
            typingTimer = setTimeout(function() {
                updateDocument();
            }, 1000);
        });

        // Update document content
        function updateDocument() {
            fetch('{{ route('projects.documents.update', [$project, $document]) }}', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    content: content.value
                })
            })
            .then(response => response.json())
            .then(data => {
                saveStatus.textContent = 'All changes saved';
            })
            .catch(error => {
                saveStatus.textContent = 'Error saving changes';
                console.error('Error:', error);
            });
        }

        // Update editor list
        function updateEditorList(documentId) {
            fetch(`/api/documents/${documentId}/editors`)
                .then(response => response.json())
                .then(data => {
                    editorCount.textContent = `${data.count} ${data.count === 1 ? 'editor' : 'editors'}`;
                    // Update editor avatars here
                });
        }

        // Handle page unload
        window.addEventListener('beforeunload', function() {
            fetch('{{ route('projects.documents.remove-editor', [$project, $document]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        });
    </script>
    @endpush
</x-app-layout> 