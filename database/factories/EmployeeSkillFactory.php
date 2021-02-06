<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\EmployeeSkill;
use App\Models\Skill;
use Faker\Generator as Faker;

$factory->define(EmployeeSkill::class, function (Faker $faker) {
    return [
        'employee_id' => factory(Employee::class)->create()->id,
        'skill_id' => factory(Skill::class)->create()->id,
    ];
});
