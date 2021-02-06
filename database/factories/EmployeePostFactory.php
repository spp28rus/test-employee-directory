<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Employee;
use App\Models\EmployeePost;
use Faker\Generator as Faker;

$factory->define(EmployeePost::class, function (Faker $faker) {
    return [
        'employee_id' => factory(Employee::class)->create()->id,
        'post_id' => factory(Post::class)->create()->id,
    ];
});
