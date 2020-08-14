<?php

namespace App;

use App\Fuzzy\Aggregations\AggregationFunction;
use App\Fuzzy\Aggregations\ArithmeticMean;
use App\Fuzzy\Aggregations\Sum;
use App\Fuzzy\Quantifiers\Quantifier;
use App\Fuzzy\Quantifiers\MostOfHaveHighOpinion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class RespondentGroup
 * @package App
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class RespondentGroup extends Model
{
    /**
     * @return HasMany
     */
    public function respondents(): HasMany
    {
        return $this->hasMany('App\Respondent');
    }

    /**
     * @return BelongsTo
     */
    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo('App\Questionnaire');
    }

    /**
     * @return BelongsToMany
     */
    public function softwareTools(): BelongsToMany
    {
        return $this->belongsToMany('App\SoftwareTool');
    }

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo('App\Company');
    }

    /**
     * @return array
     */
    public static function calculateAllAggregatedSoftwareEvaluationBySum(): array
    {
        $respondentGroups = static::all();

        $result = [];

        foreach ($respondentGroups as $respondentGroup) {
            $result[$respondentGroup->id] = $respondentGroup->quantifiedHighOpinionAggregationBySum();
        }

        return $result;
    }

    /**
     * @return array
     */
    public static function calculateAllAggregatedSoftwareEvaluationByArithmeticMean(): array
    {
        $respondentGroups = static::all();

        $result = [];

        foreach ($respondentGroups as $respondentGroup) {
            $result[$respondentGroup->id] = $respondentGroup->quantifiedHighOpinionAggregationByArithmeticMean();
        }

        return $result;
    }

    /**
     * @param SoftwareTool|null $softwareTool
     * @return float
     */
    public function quantifiedHighOpinionAggregationBySum(SoftwareTool $softwareTool = null): float
    {
        $aggregatedData = $this->aggregateRespondentsBySum($softwareTool);

        //TODO min
        return $this->quantifiedAggregation(new MostOfHaveHighOpinion(min($aggregatedData), max($aggregatedData)), $aggregatedData);
//        return $this->quantifiedAggregation(new MostOfHaveHighOpinion($min, $max), $aggregatedData);
//        return $this->quantifiedAggregation(new MostOfHaveHighOpinion(Respondent::getMinValueForAggregateAll(new Sum(), $softwareTool), Respondent::getMaxValueForAggregateAll(new Sum(), $softwareTool)), $aggregatedData);
    }

    /**
     * @param SoftwareTool|null $softwareTool
     * @return float
     */
    public function quantifiedHighOpinionAggregationByArithmeticMean(SoftwareTool $softwareTool = null): float
    {
        $aggregatedData = $this->aggregateRespondentsByArithmeticMean($softwareTool);

        //TODO min
        return $this->quantifiedAggregation(new MostOfHaveHighOpinion(min($aggregatedData), max($aggregatedData)), $aggregatedData);
//        return $this->quantifiedAggregation(new MostOfHaveHighOpinion(1, 5), $aggregatedData);
//        return $this->quantifiedAggregation(new MostOfHaveHighOpinion(Respondent::getMinValueForAggregateAll(new ArithmeticMean(), $softwareTool), Respondent::getMaxValueForAggregateAll(new ArithmeticMean(), $softwareTool)), $aggregatedData);
    }

    /**
     * @param Quantifier $quantifier
     * @param array $aggregatedData
     * @return float
     */
    public function quantifiedAggregation(Quantifier $quantifier, array $aggregatedData): float
    {
        return $quantifier->calc($aggregatedData);
    }

    /**
     * @param SoftwareTool|null $softwareTool
     * @return array
     */
    public function aggregateRespondentsBySum(SoftwareTool $softwareTool = null): array
    {
        return $this->aggregateRespondentsBy(new Sum(), $softwareTool);
    }

    /**
     * @param SoftwareTool|null $softwareTool
     * @return array
     */
    public function aggregateRespondentsByArithmeticMean(SoftwareTool $softwareTool = null): array
    {
        return $this->aggregateRespondentsBy(new ArithmeticMean(), $softwareTool);
    }

    /**
     * @param AggregationFunction $aggregationFunction
     * @param SoftwareTool|null $softwareTool
     * @return array
     */
    public function aggregateRespondentsBy(AggregationFunction $aggregationFunction, SoftwareTool $softwareTool = null): array
    {
        $result = [];

        /** @var Respondent $respondent */
        foreach ($this->respondents()->get() as $respondent) {
            $result[$respondent->id] = $respondent->aggregateAnswersBy($aggregationFunction, $softwareTool);
        }

        return $result;
    }
}
