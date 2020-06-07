<?php

/* @var $factory Factory */

use App\User;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Notifications\DatabaseNotification;
use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;

$factory->define(DatabaseNotification::class, function (Faker $faker) {
    return [
        'id' => Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function () {
            return auth()->id() ?: factory(User::class)->create()->id;
        },
        'notifiable_type' => User::class,
        'data' => ['foo' => 'bar']
    ];
});
