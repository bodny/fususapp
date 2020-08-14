<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Questionnaire;
use Faker\Generator as Faker;

$factory->define(Questionnaire::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(2, true),
    ];
});
