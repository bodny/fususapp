<?php
/**
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */

use App\Answer;
use App\Company;
use App\RespondentGroup;
use App\SoftwareTool;
use Illuminate\Database\Seeder;

/**
 * Class RandomDataSeeder
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class RandomDataSeeder extends Seeder
{
    private const QUESTIONNAIRES_COUNT = 1;
    private const QUESTIONS_PER_QUESTIONNAIRE_COUNT = 5;

    private const SOFTWARE_TOOLS_COUNT = 5;

    private const COMPANIES_COUNT = 1;
    private const RESPONDENT_GROUPS_PER_COMPANY_COUNT = 4; // max 7
    private const SOFTWARE_TOOLS_PER_RESPONDENT_GROUP_COUNT = 5;

    private const RESPONDENTS_PER_RESPONDENT_GROUP_COUNT = 17;

    private const MIN_ANSWER_VALUE = 2; //Answer::MIN_VALUE;
    private const MAX_ANSWER_VALUE = Answer::MAX_VALUE;

    private $faker;

    /**
     * RandomDataSeeder constructor.
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
    public function run(): void
    {
        $this->seedRandomQuestionnairesWithRandomQuestions();

        $this->seedRandomSoftwareTools();

        $this->seedRandomCompanyWithRandomRespondentGroupsAndAssignedSoftwareTools();

        $this->seedRandomRespondentsWithRandomAnswers();
    }

    /**
     * @param int $questionnairesCount
     * @param int $questionPerQuestionnaireCount
     */
    public function seedRandomQuestionnairesWithRandomQuestions(
        $questionnairesCount = self::QUESTIONNAIRES_COUNT,
        $questionPerQuestionnaireCount = self::QUESTIONS_PER_QUESTIONNAIRE_COUNT
    ): void {
        // Questionnaire + questions
        factory(App\Questionnaire::class, $questionnairesCount)->create()->each(
            function ($questionnaire) use ($questionPerQuestionnaireCount) {
                for ($i = 0; $i < $questionPerQuestionnaireCount; $i++) {
                    $questionnaire->questions()->save(factory(App\Question::class)->make());
                }
            }
        );
    }

    /**
     * @param int $softwareToolsCount
     */
    public function seedRandomSoftwareTools($softwareToolsCount = self::SOFTWARE_TOOLS_COUNT): void
    {
        // Software tools
        factory(App\SoftwareTool::class, $softwareToolsCount)->create();
    }

    /**
     * @param int $companiesCount
     * @param int $respondentGroupsPerCompanyCount
     * @param int $softwareToolsPerRespondentGroupCount
     */
    public function seedRandomCompanyWithRandomRespondentGroupsAndAssignedSoftwareTools(
        $companiesCount = self::COMPANIES_COUNT,
        $respondentGroupsPerCompanyCount = self::RESPONDENT_GROUPS_PER_COMPANY_COUNT,
        $softwareToolsPerRespondentGroupCount = self::SOFTWARE_TOOLS_PER_RESPONDENT_GROUP_COUNT
    ): void {
        // Company + RespondentGroups + RespondentGroupSoftwareTool
        /** @var Company $company */
        factory(App\Company::class, $companiesCount)->create()->each(
            function ($company) use ($respondentGroupsPerCompanyCount, $softwareToolsPerRespondentGroupCount) {
                for ($i = 0; $i < $respondentGroupsPerCompanyCount; $i++) {
                    $respondentGroups = null;
                    $company->respondentGroups()
                        ->save(
                            $respondentGroups = factory(App\RespondentGroup::class)
                                ->make(
                                    [
                                        'questionnaire_id' => $this->getRandomQuestionnaire(),
                                        'company_id' => $company->id,
                                    ]
                                )
                        );
                }

                $company->respondentGroups()
                    ->each(
                        function ($respondentGroup) use ($softwareToolsPerRespondentGroupCount) {
                            $resetSoftwareToolUniqueness = true;
                            for ($i = 0; $i < $softwareToolsPerRespondentGroupCount; $i++) {
                                $softwareToolId = $this->getRandomSoftwareTool($resetSoftwareToolUniqueness)->id;

                                if ($resetSoftwareToolUniqueness === true) {
                                    $resetSoftwareToolUniqueness = false;
                                }

                                $respondentGroup->softwareTools()->attach($softwareToolId);
                            }
                        }
                    );
            }
        );
    }

    /**
     * @return int
     */
    private function getRandomQuestionnaire(): int
    {
        $questionnaire = App\Questionnaire::all()->random();
        return $questionnaire->id;
    }

    /**
     * @param bool $reset
     * @return SoftwareTool
     */
    private function getRandomSoftwareTool(bool $reset = false): SoftwareTool
    {
        return $this->faker->unique($reset)->randomElement(SoftwareTool::all());
    }

    /**
     * @param int $respondentsPerRespondentGroupCount
     * @param int $minAnswerValue
     * @param int $maxAnswerValue
     */
    public function seedRandomRespondentsWithRandomAnswers(
        $respondentsPerRespondentGroupCount = self::RESPONDENTS_PER_RESPONDENT_GROUP_COUNT,
        $minAnswerValue = self::MIN_ANSWER_VALUE,
        $maxAnswerValue = self::MAX_ANSWER_VALUE
    ): void {
        $respondentGroups = RespondentGroup::all();
        foreach ($respondentGroups as $respondentGroup) {
            // Respondents + answers
            factory(App\Respondent::class, $respondentsPerRespondentGroupCount)
                ->create(['respondent_group_id' => $respondentGroup->id])
                ->each(
                    function ($respondent) use ($minAnswerValue, $maxAnswerValue) {
                        $respondentGroup = $respondent->respondentGroup()->first();
                        //get list of software tools of that user
                        $softwareTools = $respondentGroup->softwareTools()->get();

                        //get questions for questionnaire of respondent group of that respondent
                        $questions = $respondentGroup->questionnaire()->first()->questions()->get();

                        //foreach software tool
                        foreach ($softwareTools as $softwareTool) {
                            foreach ($questions as $question) {
                                $respondent->answers()->save(
                                    factory(App\Answer::class)->make(
                                        [
                                            'software_tool_id' => $softwareTool->id,
                                            'question_id' => $question->id,
                                            'value' => $this->faker->numberBetween($minAnswerValue, $maxAnswerValue),
                                        ]
                                    )
                                );
                            }
                        }
                    }
                );
        }
    }
}
