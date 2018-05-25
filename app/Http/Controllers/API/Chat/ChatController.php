<?php

namespace App\Http\Controllers\API\Chat;

use App\Http\Resources\Chat\ChatItem;
use App\Http\Resources\Chat\ChatList;
use App\Models\Chat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function index(): ChatList
    {
        return new ChatList(Chat::fetchChatList());
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Chat $chat): ChatItem
    {
        return new ChatItem($chat);
    }

    public function update(Request $request, Chat $chat)
    {
        //
    }

    public function destroy(Chat $chat): JsonResponse
    {
        return response()->json(['success' => $chat->delete()]);
    }
}
