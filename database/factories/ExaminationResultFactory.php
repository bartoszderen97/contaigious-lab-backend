<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ApplicationForExamination;
use App\Models\ExaminationResult;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(ExaminationResult::class, function (Faker $faker) {
    return [
        'illness_presence' => $faker->randomElement([0, 1]),
        'unit_name' => $faker->randomElement(['g/mol', 'mm/Hg', '%']),
        'result_value' => $faker->numberBetween(0, 100),
        'result_lowest_norm' => $faker->numberBetween(0, 100),
        'result_highest_norm' => $faker->numberBetween(0, 100),
        'added_by' => User::all()->random()->id,
        'application_id' => ApplicationForExamination::all()->random()->id,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
