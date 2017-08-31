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
$factory->define(App\Event::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'date' => $faker->date,
        'start' => $faker->time,
        'end' => $faker->time,
        'hours' => $faker->randomDigit,
        'officer_id' => null
    ];
});

$factory->define(App\Meeting::class, function (Faker\Generator $faker) {
    return [
        'date_time' => $faker->dateTime,
        'information' => $faker->paragraph
    ];
});

$factory->define(App\Member::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->randomNumber(4),
        'first' => $faker->firstName,
        'last' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'graduation' => $faker->numberBetween(2000, 2100),
        'phone' => $faker->phoneNumber
    ];
});

$factory->define(App\Officer::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'member_id' => null
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'member_id' => null
    ];
});
