<?php

namespace App;

use App\Fuzzy\Aggregations\AggregationFunction;
use App\Fuzzy\Aggregations\ArithmeticMean;
use App\Fuzzy\Aggregations\GeometricMean;
use App\Fuzzy\Aggregations\Sum;
use App\Fuzzy\Aggregations\YagerRybalovUniformProductAggregation;
use App\Fuzzy\Quantifiers\MostOfHaveHighOpinion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class SoftwareTool
 * @package App
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class SoftwareTool extends Model
{
    /**
     * @return BelongsToMany
     */
    public function respondentGroups(): BelongsToMany
    {
        return $this->belongsToMany('App\RespondentGroup');
    }

    /**
     * @return array
     */
    public static function aggregateAllSoftwareEvaluationBySumAndUniform(): array
    {
        return static::aggregateAllSoftwareEvaluationBy(new Sum(), new YagerRybalovUniformProductAggregation());
    }

    /**
     * @return array
     */
    public static function aggregateAllSoftwareEvaluationBySumAndGeometricMean(): array
    {
        return static::aggregateAllSoftwareEvaluationBy(new Sum(), new GeometricMean());
    }

    /**
     * @return array
     */
    public static function aggregateAllSoftwareEvaluationByArithmeticMeanAndUniform(): array
    {
        return static::aggregateAllSoftwareEvaluationBy(new ArithmeticMean(), new YagerRybalovUniformProductAggregation());
    }

    /**
     * @return array
     */
    public static function aggregateAllSoftwareEvaluationByArithmeticAndGeometricMean(): array
    {
        return static::aggregateAllSoftwareEvaluationBy(new ArithmeticMean(), new GeometricMean());
    }

    /**
     * @param AggregationFunction $aggregationFunctionForRespondents
     * @param AggregationFunction $aggregationFunctionForSoftwareTool
     * @return array
     */
    private static function aggregateAllSoftwareEvaluationBy(AggregationFunction $aggregationFunctionForRespondents, AggregationFunction $aggregationFunctionForSoftwareTool): array
    {
        $softwareTools = static::all();

        $result = [];

        foreach ($softwareTools as $softwareTool) {
            $result[$softwareTool->id] = $softwareTool->aggregateSoftwareEvaluationBy($aggregationFunctionForRespondents, $aggregationFunctionForSoftwareTool);
        }

        return $result;
    }

    /**
     * @return float
     */
    public function aggregateSoftwareEvaluationBySumAndUniform(): ?float
    {
        return $this->aggregateSoftwareEvaluationBy(new Sum(), new YagerRybalovUniformProductAggregation());
    }

    /**
     * @return float
     */
    public function aggregateSoftwareEvaluationBySumAndGeometricMean(): ?float
    {
        return $this->aggregateSoftwareEvaluationBy(new Sum(), new GeometricMean());
    }

    /**
     * @return float
     */
    public function aggregateSoftwareEvaluationByArithmeticMeanAndUniform(): ?float
    {
        return $this->aggregateSoftwareEvaluationBy(new ArithmeticMean(), new YagerRybalovUniformProductAggregation());
    }

    /**
     * @return float
     */
    public function aggregateSoftwareEvaluationByArithmeticMeanAndGeometricMean(): ?float
    {
        return $this->aggregateSoftwareEvaluationBy(new ArithmeticMean(), new GeometricMean());
    }

    /**
     * @param AggregationFunction $aggregationFunctionForRespondents
     * @param AggregationFunction $aggregationFunctionForSoftwareTool
     * @return float
     */
    public function aggregateSoftwareEvaluationBy(AggregationFunction $aggregationFunctionForRespondents, AggregationFunction $aggregationFunctionForSoftwareTool): ?float
    {
        $data = [];

        /** @var RespondentGroup $respondentGroup */
        foreach ($this->respondentGroups()->get() as $respondentGroup) {
            $aggregatedData = $respondentGroup->aggregateRespondentsBy($aggregationFunctionForRespondents, $this);

            //TODO min
            $data[$respondentGroup->id] = $respondentGroup->quantifiedAggregation(new MostOfHaveHighOpinion(min($aggregatedData), max($aggregatedData)), $aggregatedData);
//            $data[$respondentGroup->id] = $respondentGroup->quantifiedAggregation(new MostOfHaveHighOpinion($min, $max), $aggregatedData);
//            $data[$respondentGroup->id] = $respondentGroup->quantifiedAggregation(new MostOfHaveHighOpinion(Respondent::getMinValueForAggregateAll($aggregationFunctionForRespondents, $this), Respondent::getMaxValueForAggregateAll($aggregationFunctionForRespondents, $this)), $aggregatedData);
        }

        return $aggregationFunctionForSoftwareTool->calc($data);
    }

    /**
     * @param RespondentGroup $respondentGroup
     * @param AggregationFunction $aggregationFunctionForRespondents
     * @return float
     */
    public function aggregateSoftwareEvaluationForRespondentGroupBy(RespondentGroup $respondentGroup, AggregationFunction $aggregationFunctionForRespondents): float
    {
        $aggregatedData = $respondentGroup->aggregateRespondentsBy($aggregationFunctionForRespondents, $this);

        //TODO min
        return $respondentGroup->quantifiedAggregation(new MostOfHaveHighOpinion(min($aggregatedData), max($aggregatedData)), $aggregatedData);
//        return $respondentGroup->quantifiedAggregation(new MostOfHaveHighOpinion($min, $max), $aggregatedData);
//        return $respondentGroup->quantifiedAggregation(new MostOfHaveHighOpinion(Respondent::getMinValueForAggregateAll($aggregationFunctionForRespondents, $this), Respondent::getMaxValueForAggregateAll($aggregationFunctionForRespondents, $this)), $aggregatedData);
    }

    /**
     * @return array
     */
    public static function aggregateAllSoftwareEvaluationPerRespondentGroupBySum()
    {
        return static::aggregateAllSoftwareEvaluationPerRespondentGroupBy(new Sum());
    }

    /**
     * @return array
     */
    public static function aggregateAllSoftwareEvaluationPerRespondentGroupByArithmeticMean()
    {
        return static::aggregateAllSoftwareEvaluationPerRespondentGroupBy(new ArithmeticMean());
    }

    /**
     * @param AggregationFunction $aggregationFunctionForRespondents
     * @return array
     */
    private static function aggregateAllSoftwareEvaluationPerRespondentGroupBy(AggregationFunction $aggregationFunctionForRespondents)
    {
        $softwareTools = SoftwareTool::all();

        $result = [];

        foreach ($softwareTools as $softwareTool) {
            foreach ($softwareTool->respondentGroups()->get() as $respondentGroup) {
                $result[$softwareTool->id][$respondentGroup->id] = $softwareTool->aggregateSoftwareEvaluationForRespondentGroupBy($respondentGroup, $aggregationFunctionForRespondents);
            }
        }

        return $result;
    }
}
