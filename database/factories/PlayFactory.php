<?php

use App\Models\Play;
use Faker\Generator as Faker;

$factory->define(App\Play::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'author' => $faker->name(),
    ];
});
