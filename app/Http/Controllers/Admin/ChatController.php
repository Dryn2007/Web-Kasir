<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        // Ambil daftar user yang pernah chat, urutkan dari yang terbaru chat-nya
        $users = User::whereHas('chats')
            ->with(['chats' => function ($q) {
                $q->latest();
            }])
            ->get()
            ->sortByDesc(function ($user) {
                return $user->chats->first()->created_at;
            });

        return view('admin.chat.index', compact('users'));
    }

    public function show($userId)
    {
        $users = User::whereHas('chats')->get(); // List sidebar
        $activeUser = User::findOrFail($userId);

        // Ambil chat spesifik user ini & tandai sudah dibaca
        $chats = Chat::where('user_id', $userId)->orderBy('created_at', 'asc')->get();

        Chat::where('user_id', $userId)->where('is_admin', false)->update(['is_read' => true]);

        return view('admin.chat.index', compact('users', 'activeUser', 'chats'));
    }

    public function reply(Request $request, $userId)
    {
        $request->validate(['message' => 'required']);

        Chat::create([
            'user_id' => $userId, // Pesan ini milik percakapan user tersebut
            'message' => $request->message,
            'is_admin' => true, // Ini balasan admin
        ]);

        return redirect()->route('admin.chat.show', $userId);
    }
}
