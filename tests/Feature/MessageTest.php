<?php

namespace Tests\Feature;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function message_factory_test()
    {
        $body = 'Hello World';
        $message = factory(Message::class)->create(['body' => $body]);

        $this->assertEquals($body, $message->body);
    }

    /** @test */
    public function user_relationship_test()
    {
        $user = factory(User::class)->create();
        $message = factory(Message::class)->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $message->user->id);
    }

    /** @test */
    public function chat_relationship_test()
    {
        $chat = factory(Chat::class)->create();
        $message = factory(Message::class)->create(['chat_id' => $chat->id]);

        $this->assertEquals($chat->id, $message->chat->id);
    }

    /** @test */
    public function is_myself_attribute_test()
    {
        $user = factory(User::class)->create();
        auth()->login($user);
        $message = factory(Message::class)->create(['user_id' => $user->id]);

        $this->assertEquals(true, $message->is_myself);
    }
}
