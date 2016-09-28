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

use Illuminate\Support\Facades\Auth;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Equipment::class, function (Faker\Generator $faker) {
    return [
        
            'item' => 'PILOT WYTEBOARD MARKER (BLACK)',
            'category_id' => 1,
            'description' => 'PILOT WYTEBOARD MARKER (BLACK)',
            'user_id' => 1,
            'status' => 1,
            'consumable' => 1,
            'outOfStock' => 0,
            'hasQuantity' => 1,
        
    ];
});

