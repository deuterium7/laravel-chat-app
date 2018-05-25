<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;

class ChatItem extends Controller
{
    /**
     * Детальная страница чата.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(int $id)
    {
        return view('chat.show', compact('id'));
    }
}
