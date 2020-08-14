<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Respondent;
use App\RespondentGroup;
use Faker\Generator as Faker;

$factory->define(Respondent::class, function (Faker $faker) {
    return [
        'uuid' => $faker->uuid,
//        'respondent_group_id' => function () {
//            return factory(App\RespondentGroup::class)->create()->id;
//        }, // TODO retrieve existing respondent group
    ];
});
