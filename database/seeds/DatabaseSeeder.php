<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;
use App\Core\Constants;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Alex Zabornyi',
            'email' => 'post0778@gmail.com',
            'password' => '$2y$10$2RA3tS/YLT6nAvGTpz0p1eF9aVnZcYArJ5sUDKpGzZfZUwb5Tfsn2',
        ]);

        $users = factory(User::class, 10)->create();

        $chats = factory(Chat::class, 15)->create([
            'user_id' => function () use ($users) {
                return $users->random()->id;
            },
            'type' => Constants::CHAT_TYPE_PUBLIC,
        ]);

        factory(Message::class, 1000)->create([
            'user_id' => function () use ($users) {
                return $users->random()->id;
            },
            'chat_id' => function () use ($chats) {
                return $chats->random()->id;
            },
        ]);
    }
}
