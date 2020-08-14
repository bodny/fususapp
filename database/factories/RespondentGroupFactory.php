<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use App\Questionnaire;
use App\RespondentGroup;
use Faker\Generator as Faker;

$factory->define(RespondentGroup::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->randomElement(['Managers', 'IT Developers', 'Accounting department', 'Sales', 'Marketing', 'Engineers', 'Directors']), //, 'IT Support', 'Sales', 'Marketing'
//        'company_id' => function () {
//            return factory(App\Company::class)->create()->id;
//        }, // TODO retrieve existing company
//        'questionnaire_id' => function () {
//            return factory(App\Questionnaire::class)->create()->id;
//        }, // TODO retrieve existing questionnaire
    ];
});
