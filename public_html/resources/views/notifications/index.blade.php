@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Notifications</h1>
        <div class="flex space-x-4">
            @if($notifications->where('read_at', null)->count() > 0)
                <button onclick="markAllAsRead()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Mark All as Read
                </button>
            @endif
            @if($notifications->count() > 0)
                <button onclick="clearAllNotifications()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Clear All
                </button>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        @if($notifications->isEmpty())
            <div class="p-6 text-center text-gray-500">
                No notifications found
            </div>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($notifications as $notification)
                    <li class="p-4 hover:bg-gray-50 {{ $notification->read_at ? 'bg-gray-50' : 'bg-white' }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                @if(isset($notification->data['sender_avatar']))
                                    <img src="{{ $notification->data['sender_avatar'] }}" alt="Avatar" class="w-10 h-10 rounded-full">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-indigo-600 font-bold text-lg">
                                            {{ substr($notification->data['sender_name'] ?? 'U', 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm text-gray-600">{{ $notification->data['message'] }}</p>
                                    <p class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                @if(!$notification->read_at)
                                    <button onclick="markAsRead('{{ $notification->id }}')" class="text-blue-500 hover:text-blue-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                @endif
                                <button onclick="deleteNotification('{{ $notification->id }}')" class="text-red-500 hover:text-red-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function markAsRead(id) {
    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function markAllAsRead() {
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function deleteNotification(id) {
    if (confirm('Are you sure you want to delete this notification?')) {
        fetch(`/notifications/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function clearAllNotifications() {
    if (confirm('Are you sure you want to clear all notifications?')) {
        fetch('/notifications/clear-all', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>
@endpush
@endsection 