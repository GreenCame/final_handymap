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
use App\user;
use App\Point;
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'pseudo' => $faker->name,
        'email' => $faker->safeEmail,
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'warnings' => $faker->randomDigit,
        'isVoice' => $faker->boolean(30),
        'isColor' => $faker->boolean(40),
        'isBlocked' => $faker->boolean(20),
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});
$factory->defineAs(App\User::class, 'admin', function (Faker\Generator $faker) {
    return [
        'pseudo' => "Admin",
        'email' => "admin@gmail.com",
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'warnings' => 0,
        'isVoice' => true,
        'isAdmin' => true,
        'isColor' => true,
        'isBlocked' => false,
        'password' => bcrypt("Password")
    ];
});

$factory->define(App\Feedback::class, function (Faker\Generator $faker) {
    return [
        'comment' => $faker->paragraph,
        'user_id' => function () {
            return User::orderByRaw("RAND()")->first()->id;
        }
    ];
});

$factory->define(App\Confirmation::class, function (Faker\Generator $faker) {
    return [
        'rateValue' => $faker->randomElement(array(1,2,3,4,5)),
        'isConfirm' => $faker->boolean(50),
        'description' => $faker->paragraph,
        'user_id' => function () {
            return User::orderByRaw("RAND()")->first()->id;
        },
         'point_id' => function () {
             return Point::orderByRaw("RAND()")->first()->id;
        }
    ];
});

$factory->define(App\Point::class, function (Faker\Generator $faker) {
    return [
        'rateValue' => $faker->randomElement(array(1,2,3,4,5)),
        'description' => $faker->paragraph,
        'longitude' => $faker->randomFloat(9,1,900),
        'latitude' => $faker->randomFloat(9,1,900),
        'isValidate' => $faker->boolean(40),
        'user_id' => function () {
            return User::orderByRaw("RAND()")->first()->id;
        }
    ];
});