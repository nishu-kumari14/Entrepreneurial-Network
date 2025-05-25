<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $notifications = auth()->user()->notifications()
            ->with('sender')
            ->latest()
            ->paginate(20);

        $unreadCount = auth()->user()->notifications()
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        $this->authorize('markAsRead', $notification);
        
        $this->notificationService->markAsRead($notification);

        return response()->json(['message' => 'Notification marked as read']);
    }

    public function markAllAsRead()
    {
        $this->notificationService->markAllAsRead(auth()->user());

        return response()->json(['message' => 'All notifications marked as read']);
    }
} 