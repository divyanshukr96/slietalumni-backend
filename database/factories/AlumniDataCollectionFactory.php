<?php

use Faker\Generator as Faker;

$factory->define(App\AlumniDataCollection::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'mobile' => $faker->phoneNumber,
        'programme' => $faker->randomElement(['Certificate', 'Diploma', 'ICD', 'UG', 'PG', ]),
        'batch' => $faker->year('2016'),
        'branch' => $faker->randomElement(['CSE', 'ECE', 'IN', 'EE', 'ME',]),
        'passing' => $faker->year,
        'organisation' => $faker->company
    ];
});
