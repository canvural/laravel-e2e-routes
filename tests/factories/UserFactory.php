<?php

declare(strict_types=1);

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(App\User::class, static function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});

$factory->state(App\User::class, 'withFooName', ['name' => 'foo']);
