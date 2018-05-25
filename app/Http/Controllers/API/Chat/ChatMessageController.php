<?php

namespace App\Http\Controllers\API\Chat;

use App\Http\Requests\Chat\ChatMessageRequest;
use App\Http\Resources\Chat\ChatItemMessageList;
use App\Models\Chat;
use App\Models\Message;
use App\Http\Controllers\Controller;

class ChatMessageController extends Controller
{
    public function index(Chat $chat): ChatItemMessageList
    {
        return new ChatItemMessageList(
            $chat->messages()
                ->orderBy('created_at', 'desc')
                ->get()
        );
    }

    public function store(Chat $chat, ChatMessageRequest $request)
    {
        $success = !!Message::create([
            'user_id' => auth()->id(),
            'chat_id' => $chat->id,
            'body' => $request->body,
        ]);

        return response()->json(['success' => $success]);
    }

    public function show(Chat $chat, Message $message)
    {
        //
    }

    public function update(Chat $chat, ChatMessageRequest $request, Message $message)
    {
        //
    }

    public function destroy(Chat $chat, Message $message)
    {
        //
    }
}
