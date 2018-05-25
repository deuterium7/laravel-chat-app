<?php

use Faker\Generator as Faker;
use App\Models\Message;
use App\Models\User;
use App\Models\Chat;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'chat_id' => function () {
            return factory(Chat::class)->create()->id;
        },
        'body' => $faker->sentence,
    ];
});
