<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
//        'respondent_id' => function () {
//            return factory(App\Respondent::class)->create()->id;
//        }, // TODO retrieve existing respondent
//        'software_tool_id' => function () {
//            return factory(App\SoftwareTool::class)->create()->id;
//        }, // TODO retrieve existing software tool
//        'question_id' => function () {
//            return factory(App\Question::class)->create()->id;
//        }, // TODO retrieve existing question
        'value' => $faker->numberBetween(Answer::MIN_VALUE, Answer::MAX_VALUE),
    ];
});
