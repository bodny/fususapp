<?php

use App\RespondentGroup;
use Illuminate\Database\Seeder;

/**
 * Class ArticleTestDataSeeder
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class ArticleTestDataSeeder extends Seeder
{
    private const QUESTIONNAIRES_COUNT = 1;
    private const QUESTIONS_PER_QUESTIONNAIRE_COUNT = 5;

    private const SOFTWARE_TOOLS_COUNT = 1;

    private const COMPANIES_COUNT = 1;
    private const RESPONDENT_GROUPS_PER_COMPANY_COUNT = 1; // max 7
    private const SOFTWARE_TOOLS_PER_RESPONDENT_GROUP_COUNT = 1;

    private const RESPONDENTS_PER_RESPONDENT_GROUP_COUNT = 17;

    private const VALUES_FROM_ARTICLE = [
           [1, 2, 2, 3, 2], // R1
           [5, 2, 4, 5, 4], // R2
           [2, 1, 4, 3, 4], // R3
           [3, 3, 3, 3, 3], // R4
           [2, 5, 4, 1, 5], // R5
           [4, 4, 4, 5, 4], // R6
           [3, 3, 3, 3, 3], // R7
           [1, 1, 2, 3, 1], // R8
           [4, 4, 4, 4, 4], // R9
           [4, 5, 4, 5, 4], // R10
           [4, 5, 3, 3, 5], // R11
           [5, 4, 3, 2, 5], // R12
           [4, 4, 4, 5, 4], // R13
           [4, 5, 5, 4, 5], // R14
           [4, 5, 4, 4, 3], // R15
           [3, 2, 5, 3, 4], // R16
           [1, 2, 3, 1, 1], // R17
    ];

    private $faker;

    /**
     * ArticleTestDataSeeder constructor.
     * @param \Faker\Generator $faker
     */
    public function __construct(Faker\Generator $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $randomDataSeeder = new RandomDataSeeder($this->faker);

        $randomDataSeeder->seedRandomQuestionnairesWithRandomQuestions(
            self::QUESTIONNAIRES_COUNT,
            self::QUESTIONS_PER_QUESTIONNAIRE_COUNT
        );

        $randomDataSeeder->seedRandomSoftwareTools(self::SOFTWARE_TOOLS_COUNT);

        $randomDataSeeder->seedRandomCompanyWithRandomRespondentGroupsAndAssignedSoftwareTools(
            self::COMPANIES_COUNT,
            self::RESPONDENT_GROUPS_PER_COMPANY_COUNT,
            self::SOFTWARE_TOOLS_PER_RESPONDENT_GROUP_COUNT
        );

        $this->seedRandomRespondentsWithRandomAnswers();
    }

    public function seedRandomRespondentsWithRandomAnswers(
        $respondentsPerRespondentGroupCount = self::RESPONDENTS_PER_RESPONDENT_GROUP_COUNT
    ): void {
        $respondentGroups = RespondentGroup::all();
        foreach ($respondentGroups as $respondentGroup) {
            // Respondents + answers
            $i = 0;
            factory(App\Respondent::class, $respondentsPerRespondentGroupCount)
                ->create(['respondent_group_id' => $respondentGroup->id])
                ->each(
                    function ($respondent) use (&$i) {
                        $respondentGroup = $respondent->respondentGroup()->first();
                        //get list of software tools of that user
                        $softwareTools = $respondentGroup->softwareTools()->get();

                        //get questions for questionnaire of respondent group of that respondent
                        $questions = $respondentGroup->questionnaire()->first()->questions()->get();

                        $y = 0;
                        //foreach software tool
                        foreach ($softwareTools as $softwareTool) {
                            foreach ($questions as $question) {
                                $respondent->answers()->save(
                                    factory(App\Answer::class)->make(
                                        [
                                            'software_tool_id' => $softwareTool->id,
                                            'question_id' => $question->id,
                                            'value' => self::VALUES_FROM_ARTICLE[$i][$y],
                                        ]
                                    )
                                );
                                $y++;
                            }
                        }
                        $i++;
                    }
                );
        }
    }
}
