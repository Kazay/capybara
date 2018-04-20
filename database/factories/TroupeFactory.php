<?php

use App\Models\Troupe;
use Faker\Generator as Faker;

$factory->define(App\Models\Troupe::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'created_at' => $faker->dateTime('now', 'Europe/Paris'),
        'updated_at' => $faker->dateTime('now', 'Europe/Paris')
    ];
});
