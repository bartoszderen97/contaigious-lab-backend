<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Faker\Provider\pl_PL\Person as Person;

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

$factory->define(User::class, function (Faker $faker) {
    $gender = $faker->randomElement(["M", "F", "O"]);
    switch ($gender) {
        case "M":
            $firstName = $faker->firstNameMale;
            $lastName = $faker->lastNameMale;
            $pesel = (string)$faker->unique()->pesel(null, $gender);
            break;
        case "F":
            $firstName = $faker->firstNameFemale;
            $lastName = $faker->lastNameFemale;
            $pesel = (string)$faker->unique()->pesel(null, $gender);
            break;
        case "O":
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $pesel = (string)$faker->unique()->pesel;
            break;
    }
    if(strlen($pesel)==10)
        $pesel='0'.$pesel;
    return [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $faker->unique()->email,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'pesel' => $pesel,
        'gender' => $gender,
        'role' => $faker->randomElement(['client', "worker", "admin"]),
        'lang' => $faker->randomElement(['pl', 'en']),
        'remember_token' => Str::random(10),
    ];
});
