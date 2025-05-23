<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $conversations = Message::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) {
                return $message->sender_id === Auth::id() 
                    ? $message->receiver_id 
                    : $message->sender_id;
            })
            ->map(function ($messages) {
                $otherUserId = $messages->first()->sender_id === Auth::id()
                    ? $messages->first()->receiver_id
                    : $messages->first()->sender_id;
                
                $user = User::find($otherUserId);
                
                if (!$user) {
                    return null;
                }

                return [
                    'user' => $user,
                    'last_message' => $messages->first(),
                    'unread_count' => $messages->where('receiver_id', Auth::id())
                        ->whereNull('read_at')
                        ->count()
                ];
            })
            ->filter() // Remove null conversations
            ->values(); // Reset array keys

        return view('messages.index', compact('conversations'));
    }

    public function show(User $user)
    {
        $messages = Message::betweenUsers(Auth::user(), $user)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('messages.show', compact('messages', 'user'));
    }

    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'content' => $validated['content']
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => $message->load('sender', 'receiver')
            ]);
        }

        return back()->with('success', 'Message sent successfully.');
    }

    public function markAsRead(Message $message)
    {
        if ($message->receiver_id !== Auth::id()) {
            abort(403);
        }

        $message->markAsRead();

        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('messages.create');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $users = User::where('id', '!=', Auth::id())
            ->when($query, function ($q) use ($query) {
                $q->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%");
                });
            })
            ->get();

        return view('messages.create', compact('users', 'query'));
    }
} 