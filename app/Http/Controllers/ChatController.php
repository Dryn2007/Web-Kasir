<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // User kirim pesan
    public function send(Request $request)
    {
        $request->validate(['message' => 'required|string']);

        Chat::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_admin' => false, // Ini dari user
        ]);

        return response()->json(['status' => 'success']);
    }

    // Ambil pesan untuk widget (JSON)
    public function getMessages()
    {
        $chats = Chat::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($chats);
    }

    public function markAsRead()
    {
        Chat::where('user_id', Auth::id())
            ->where('is_admin', true) // Pesan dari Admin
            ->where('is_read', false) // Yang belum dibaca
            ->update(['is_read' => true]);

        return response()->json(['status' => 'success']);
    }
}
