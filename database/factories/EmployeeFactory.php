<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Employee;
use App\User;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'full_name' => (
            $faker->firstName
            . ' ' . $faker->lastName
            . ' ' . $faker->userName
        ),
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
    ];
});
