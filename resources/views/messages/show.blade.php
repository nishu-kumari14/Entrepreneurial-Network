<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                <a href="{{ route('messages.index') }}" class="mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                {{ __('Conversation with') }} {{ $user->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div id="messages-container" class="space-y-4 mb-4 h-[500px] overflow-y-auto">
                        @foreach($messages as $message)
                            <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <div class="flex items-end {{ $message->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                                    <div class="flex-shrink-0 mx-2">
                                        <img class="h-8 w-8 rounded-full object-cover" 
                                             src="{{ $message->sender->profile_picture_url }}" 
                                             alt="{{ $message->sender->name }}">
                                    </div>
                                    <div class="{{ $message->sender_id === auth()->id() ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-900' }} rounded-lg px-4 py-2 max-w-sm">
                                        <p class="text-sm">{{ $message->content }}</p>
                                        <p class="text-xs {{ $message->sender_id === auth()->id() ? 'text-indigo-200' : 'text-gray-500' }} mt-1">
                                            {{ $message->created_at->format('g:i A') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form action="{{ route('messages.store', $user) }}" method="POST" class="mt-4" id="message-form">
                        @csrf
                        <div class="flex space-x-4">
                            <div class="flex-1">
                                <x-textarea
                                    name="content"
                                    id="content"
                                    rows="1"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="{{ __('Type your message...') }}"
                                    required
                                ></x-textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            </div>
                            <div class="flex items-end">
                                <x-primary-button type="submit">
                                    {{ __('Send') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Scroll to bottom of messages container
        const messagesContainer = document.getElementById('messages-container');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Handle form submission
        const form = document.getElementById('message-form');
        const textarea = document.getElementById('content');

        form.addEventListener('submit', function(e) {
            if (textarea.value.trim() === '') {
                e.preventDefault();
                return;
            }
        });

        // Auto-resize textarea
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        // Handle enter key
        textarea.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (this.value.trim() !== '') {
                    form.submit();
                }
            }
        });
    </script>
    @endpush
</x-app-layout> 