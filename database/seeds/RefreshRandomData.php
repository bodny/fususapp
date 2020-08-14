<?php

use App\Answer;
use App\Company;
use App\Question;
use App\Questionnaire;
use App\Respondent;
use App\RespondentGroup;
use App\SoftwareTool;
use Illuminate\Database\Seeder;

/**
 * Class RefreshRandomData
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class RefreshRandomData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate();

        $this->call(RandomDataSeeder::class);
    }

    public function truncate()
    {
        Answer::query()->delete();
        Question::query()->delete();
        Respondent::query()->delete();
        RespondentGroup::query()->delete();
        SoftwareTool::query()->delete();
        Questionnaire::query()->delete();
        Company::query()->delete();
    }
}
