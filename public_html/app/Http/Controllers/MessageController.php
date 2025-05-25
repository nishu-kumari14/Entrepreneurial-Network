<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $conversations = Message::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->groupBy(function ($message) {
                return $message->sender_id === auth()->id() 
                    ? $message->receiver_id 
                    : $message->sender_id;
            })
            ->map(function ($messages) {
                return $messages->first();
            });

        return view('messages.index', compact('conversations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('messages.search');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        event(new MessageSent($message));

        // Send notification
        $this->notificationService->sendMessageNotification(
            \App\Models\User::find($request->receiver_id),
            auth()->user(),
            $message
        );

        return response()->json($message->load('sender'));
    }

    /**
     * Display the specified resource.
     */
    public function show($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', auth()->id());
        })->with(['sender', 'receiver'])
          ->latest()
          ->paginate(20);

        $recipient = auth()->user()->id === $userId 
            ? auth()->user() 
            : \App\Models\User::findOrFail($userId);

        return view('messages.show', compact('messages', 'recipient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        $this->authorize('delete', $message);
        $message->delete();

        return back()->with('success', 'Message deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $users = User::where('id', '!=', Auth::id())
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%");
            })
            ->get();

        return view('messages.search', compact('users', 'query'));
    }

    public function markAsRead($userId)
    {
        Message::where('sender_id', $userId)
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['message' => 'Messages marked as read']);
    }
}
