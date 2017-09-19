<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Word::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'spelling' => $faker->words(mt_rand(1, 2), true),
        'meaning' => $faker->sentence(mt_rand(6, 15), true),
        'excerpt' => $faker->paragraph(mt_rand(3, 9)),
        'from' => $faker->name . ' — ' .implode(' ', array_map('ucfirst', $faker->words(mt_rand(3, 10)))),
        'mastered' => $faker->boolean,
    ];
});
