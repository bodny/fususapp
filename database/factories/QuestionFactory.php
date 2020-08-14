<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'text' => $faker->realText(),
//        'questionnaire_id' => function () {
//            return factory(App\Questionnaire::class)->create()->id;
//        }, // TODO retrieve existing questionnaire
        'order' => $faker->numberBetween(1, 30),
    ];
});
