<?php

namespace App\Console\Commands;

use App\Respondent;
use App\RespondentGroup;
use App\SoftwareTool;
use Illuminate\Console\Command;

/**
 * Class SoftwareUsabilityAnalysis
 * @package App\Console\Commands
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class SoftwareUsabilityAnalysis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fususapp:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('1. Respondent level aggregation');

        $this->info(' - 1.1 respondent level aggregation by sum');
        $respondentLevelAggregationBySum = Respondent::aggregateAllBySum();
        $this->line(print_r($respondentLevelAggregationBySum, true));

        $this->info(' - 1.2 respondent level aggregation by arithmetic mean');
        $respondentLevelAggregationByArithmeticMean = Respondent::aggregateAllByArithmeticMean();
        $this->line(print_r($respondentLevelAggregationByArithmeticMean, true));

        $this->info(' - 1.3 matching degrees for high opinion for sum of answers');
        $respondentLevelAggregationMatchingDegreesForSumOfAnswers = Respondent::matchDegreesForHighOpinionBySum();
        $this->line(print_r($respondentLevelAggregationMatchingDegreesForSumOfAnswers, true));

        $this->info(' - 1.4 matching degrees for high opinion for average of answers');
        $respondentLevelAggregationMatchingDegreesForAverageOfAnswers = Respondent::matchDegreesForHighOpinionByArithmeticMean();
        $this->line(print_r($respondentLevelAggregationMatchingDegreesForAverageOfAnswers, true));

        $this->info('------------------------------------------------');

        $this->info('2. Department level aggregation');

        $this->info(' - 2.1 department level aggregation - most of have high opinion - by sum');
        $departmentLevelAggregationBySum = RespondentGroup::calculateAllAggregatedSoftwareEvaluationBySum();
        $this->line(print_r($departmentLevelAggregationBySum, true));

        $this->info(' - 2.2 department level aggregation - most of have high opinion - by arithmetic mean');
        $departmentLevelAggregationByArithmeticMean = RespondentGroup::calculateAllAggregatedSoftwareEvaluationByArithmeticMean();
        $this->line(print_r($departmentLevelAggregationByArithmeticMean, true));

        $this->info('------------------------------------------------');

        $this->info('3. Software level aggregation');

        $this->info(' - 3.1 software level aggregation per respondent group by sum');
        $softwareLevelAggregationPerRespondentGroupBySum = SoftwareTool::aggregateAllSoftwareEvaluationPerRespondentGroupBySum();
        $this->line(print_r($softwareLevelAggregationPerRespondentGroupBySum, true));

        $this->info(' - 3.2 software level aggregation per respondent group by arithmetic mean');
        $softwareLevelAggregationPerRespondentGroupByArithmeticMean = SoftwareTool::aggregateAllSoftwareEvaluationPerRespondentGroupByArithmeticMean();
        $this->line(print_r($softwareLevelAggregationPerRespondentGroupByArithmeticMean, true));

        $this->info(' - 3.3 software level aggregation by sum and uniform');
        $softwareLevelAggregationBySumAndUniform = SoftwareTool::aggregateAllSoftwareEvaluationBySumAndUniform();
        $this->line(print_r($softwareLevelAggregationBySumAndUniform, true));

        $this->info(' - 3.5 software level aggregation by sum and geometric mean');
        $softwareLevelAggregationBySumAndGeometricMean = SoftwareTool::aggregateAllSoftwareEvaluationBySumAndGeometricMean();
        $this->line(print_r($softwareLevelAggregationBySumAndGeometricMean, true));

        $this->info(' - 3.4 software level aggregation by arithmetic mean and uniform');
        $softwareLevelAggregationByArithmeticAndUniform = SoftwareTool::aggregateAllSoftwareEvaluationByArithmeticMeanAndUniform();
        $this->line(print_r($softwareLevelAggregationByArithmeticAndUniform, true));

        $this->info(' - 3.6 software level aggregation by arithmetic mean and geometric mean');
        $softwareLevelAggregationByArithmeticMeanAndGeometricMean = SoftwareTool::aggregateAllSoftwareEvaluationByArithmeticAndGeometricMean();
        $this->line(print_r($softwareLevelAggregationByArithmeticMeanAndGeometricMean, true));

        return 0;
    }
}
