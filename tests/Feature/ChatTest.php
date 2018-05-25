<?php

namespace Tests\Feature;

use App\Core\Constants;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function chat_factory_test()
    {
        $type = Constants::CHAT_TYPE_PRIVATE;
        $chat = factory(Chat::class)->create(['type' => $type]);

        $this->assertEquals($type, $chat->type);
    }

    /** @test */
    public function user_relationship_test()
    {
        $user = factory(User::class)->create();
        $chat = factory(Chat::class)->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $chat->user->id);
    }

    /** @test */
    public function messages_relationship_test()
    {
        $count = 3;

        $chat = factory(Chat::class)->create();
        factory(Message::class, $count)->create(['chat_id' => $chat->id]);

        $this->assertEquals($count, $chat->messages()->count());
    }

    /** @test */
    public function users_relationship_test()
    {
        $count = 3;

        factory(User::class, $count)->create();
        $chat = factory(Chat::class)->create(['type' => Constants::CHAT_TYPE_PUBLIC]);

        $this->assertEquals($count + 1, $chat->users->count());
    }
}
