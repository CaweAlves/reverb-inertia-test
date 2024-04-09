<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class ChatController extends Controller
{

    public function index()
    {
        return Inertia::render('Chat');
    }

    public function sendMessage(Request $request)
    {
        $message = $request->newMessage;
        event(new ChatMessageSent($message));

        $messages = [];
        $messages[] = $message;

        Cache::remember('messages', 999, fn() => $messages);

        return redirect()->back()->with('messages', $messages);
    }
}
