<?php

use App\Tag;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/* @var $factory Factory */

$factory->define(Tag::class, function (Faker $faker) {
    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name,
    ];
});
