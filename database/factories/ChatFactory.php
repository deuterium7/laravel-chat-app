<?php

use Faker\Generator as Faker;
use App\Models\Chat;
use App\Models\User;

$factory->define(Chat::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'type' => $faker->randomElement(['public', 'private']),
    ];
});
