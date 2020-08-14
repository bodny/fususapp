<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\RespondentGroupSoftwareTool;
use Faker\Generator as Faker;

$factory->define(RespondentGroupSoftwareTool::class, function (Faker $faker) {
    return [
        'respondent_group_id' => $faker->randomElement(App\RespondentGroup::all())->id,
        'software_tool_id' => $faker->randomElement(App\SoftwareTool::all())->id,
    ];
});
