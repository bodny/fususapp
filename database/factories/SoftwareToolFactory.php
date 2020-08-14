<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SoftwareTool;
use Faker\Generator as Faker;

$factory->define(SoftwareTool::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3),
    ];
});
