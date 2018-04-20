<?php

use App\Models\Director;
use Faker\Generator as Faker;

$factory->define(App\Models\Director::class, function (Faker $faker) {
    return [
        'firstname' => $faker->firstname,
        'lastname' => $faker->lastname,
        'created_at' => $faker->dateTime('now', 'Europe/Paris'),
        'updated_at' => $faker->dateTime('now', 'Europe/Paris')
    ];
});
