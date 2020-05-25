<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ApplicationForExamination;
use App\Models\Examination;
use App\Models\User;
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

$factory->define(ApplicationForExamination::class, function (Faker $faker) {
    return [
        'patient_id' => User::all()->random()->id,
        'examination_id' => Examination::all()->random()->id,
        'applied_by_id' => User::all()->random()->id,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
