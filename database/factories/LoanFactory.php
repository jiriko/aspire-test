<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Loan::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return create(\App\Models\User::class)->id;
        },
        'duration' => $faker->numberBetween(1,12),
        'repayment_frequency' => $faker->numberBetween(1,12),
        'interest_rate' => $faker->numberBetween(1,20),
        'arrangement_fee' => $faker->numberBetween(100,2000),
        'amount' => $faker->numberBetween(100,10000),
    ];
});
