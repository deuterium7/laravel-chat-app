<?php

namespace Tests\Feature;

use App\Core\Constants;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_factory_test()
    {
        $name = 'John Doe';
        $user = factory(User::class)->create(['name' => $name]);

        $this->assertEquals($name, $user->name);
    }

    /** @test */
    public function chats_relationship_test()
    {
        $count = 3;

        $user = factory(User::class)->create();
        factory(Chat::class, $count)->create(['user_id' => $user->id]);

        $this->assertEquals($count, $user->chats()->count());
    }

    /** @test */
    public function messages_relationship_test()
    {
        $count = 3;

        $user = factory(User::class)->create();
        factory(Message::class, $count)->create(['user_id' => $user->id]);

        $this->assertEquals($count, $user->messages()->count());
    }

    /** @test */
    public function in_chats_relationship_test()
    {
        $count = 3;

        $user = factory(User::class)->create();
        factory(Chat::class, $count)->create(['type' => Constants::CHAT_TYPE_PUBLIC]);

        $this->assertEquals($count, $user->inChats()->count());
    }

    /** @test */
    public function is_online_attribute_test()
    {
        $user = factory(User::class)->create();
        $isLogged = auth()->login($user);

        $this->assertEquals($isLogged, $user->is_online);
    }
}
