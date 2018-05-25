<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;

class ChatList extends Controller
{
    /**
     * Список чатов (chats)
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        return view('chat.index');
    }
}
