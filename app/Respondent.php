<?php

namespace App;

use App\Fuzzy\Aggregations\AggregationFunction;
use App\Fuzzy\Aggregations\ArithmeticMean;
use App\Fuzzy\Aggregations\GeometricMean;
use App\Fuzzy\Aggregations\Sum;
use App\Fuzzy\Memberships\HighOpinionMembershipFunction;
use App\Fuzzy\Memberships\MembershipFunction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class Respondent
 * @package App
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class Respondent extends Model
{
    /**
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany('App\Answer');
    }

    /**
     * @return BelongsTo
     */
    public function respondentGroup(): BelongsTo
    {
        return $this->belongsTo('App\RespondentGroup');
    }

    public function answeredQuestions(SoftwareTool $softwareTool = null): Collection
    {
        $questions = new Collection();
        $answers = $this->answers();

        if ($softwareTool != null) {
            $answers->where('software_tool_id', '=', $softwareTool->id);
        }
        /** @var Answer $answer */
        foreach ($answers->get() as $answer) {
            $questions->add($answer->question()->first());
        }

        return $questions;
    }

    public function answeredQuestionnaires(SoftwareTool $softwareTool = null): Collection
    {
        $questionnaires = new Collection();

        /** @var Question $question */
        foreach ($this->answeredQuestions($softwareTool) as $question) {
            $questionnaires->add($question->questionnaire()->first());
        }

        return $questionnaires->unique('id');
    }

    /**
     * @return array
     */
    public static function aggregateAllBySum(): array
    {
        return static::aggregateAllBy(new Sum());
    }

    /**
     * @param AggregationFunction $aggregationFunction
     * @param SoftwareTool|null $softwareTool
     * @return float
     */
    public function aggregateAnswersBy(AggregationFunction $aggregationFunction, SoftwareTool $softwareTool = null): float
    {
        $data = [];

        $answers = $this->answers();

        if ($softwareTool !== null) {
            $answers->where('software_tool_id', '=', $softwareTool->id);
        }

        /** @var Answer $answer */
        foreach ($answers->get() as $answer) {
            $data['q:' . $answer->question()->get()->first()->id . '_s:' . $answer->software_tool_id] = $answer->value;
        }

        return $aggregationFunction->calc($data);
    }

    /**
     * @param AggregationFunction $aggregationFunction
     * @param SoftwareTool $softwareTool
     * @return array
     */
    private static function aggregateAllBy(AggregationFunction $aggregationFunction, SoftwareTool $softwareTool = null): array
    {
        $respondents = static::all();

        $result = [];

        foreach ($respondents as $respondent) {
            $result[$respondent->id] = $respondent->aggregateAnswersBy($aggregationFunction, $softwareTool);
        }

        return $result;
    }

    /**
     * @param SoftwareTool|null $softwareTool
     * @return array
     */
    public static function aggregateAllByArithmeticMean(SoftwareTool $softwareTool = null): array
    {
        return static::aggregateAllBy(new ArithmeticMean(), $softwareTool);
    }

    /**
     * @param SoftwareTool|null $softwareTool
     * @return array
     */
    public static function matchDegreesForHighOpinionBySum(SoftwareTool $softwareTool = null): array
    {
        return static::matchDegreesForHighOpinionBy(new Sum(), $softwareTool);
    }

    /**
     * @return array
     */
    public static function matchDegreesForHighOpinionByArithmeticMean(): array
    {
        return static::matchDegreesForHighOpinionBy(new ArithmeticMean());
    }

    /**
     * @param AggregationFunction $aggregationFunction
     * @param SoftwareTool|null $softwareTool
     * @return array
     */
    private static function matchDegreesForHighOpinionBy(AggregationFunction $aggregationFunction, SoftwareTool $softwareTool = null): array
    {
        $aggregatedData = static::aggregateAllBy($aggregationFunction, $softwareTool);

        //TODO min
        $highOpinionMembershipFunction = new HighOpinionMembershipFunction(min($aggregatedData), max($aggregatedData));
//        $highOpinionMembershipFunction = new HighOpinionMembershipFunction($min, $max);
//        $highOpinionMembershipFunction = new HighOpinionMembershipFunction(Respondent::getMinValueForAggregateAll($aggregationFunction, $softwareTool), Respondent::getMaxValueForAggregateAll($aggregationFunction, $softwareTool));

        return static::matchDegreesFor($highOpinionMembershipFunction, $aggregatedData);
    }

    /**
     * @param MembershipFunction $membershipFunction
     * @param array $aggregatedData
     * @return array
     */
    private static function matchDegreesFor(
        MembershipFunction $membershipFunction,
        array $aggregatedData
    ): array {
        $result = [];

        foreach ($aggregatedData as $id => $value) {
            $result[$id] = $membershipFunction->calc($value);
        }

        return $result;
    }

    /**
     * @param SoftwareTool|null $softwareTool
     * @return float
     */
    public function aggregateAnswersBySum(SoftwareTool $softwareTool = null): float
    {
        return $this->aggregateAnswersBy(new Sum(), $softwareTool);
    }

    /**
     * @param SoftwareTool|null $softwareTool
     * @return float
     */
    public function aggregateAnswersByArithmeticMean(SoftwareTool $softwareTool = null): float
    {
        return $this->aggregateAnswersBy(new ArithmeticMean(), $softwareTool);
    }

    /**
     * @param AggregationFunction $aggregationFunction
     * @param SoftwareTool|null $softwareTool
     * @return float|int
     */
    public static function getMinValueForAggregateAll(AggregationFunction $aggregationFunction, SoftwareTool $softwareTool = null)
    {
        if ($aggregationFunction instanceof GeometricMean || $aggregationFunction instanceof ArithmeticMean) {
            return Answer::MIN_VALUE;
        }

        $respondents = Respondent::all();

        $answersCount = new Collection();
        /** @var Respondent $respondent */
        foreach ($respondents as $respondent) {
            $answers = $respondent->answers();

            if ($softwareTool != null) {
                $answers->where('software_tool_id', '=', $softwareTool->id);
            }

            $answersCount->add($answers->get()->count());
        }

        if ($aggregationFunction instanceof Sum) {
            return Answer::MIN_VALUE * $answersCount->min(); // MIN_VALUE * min(count of answered questions per respondent)
        }

        throw new \InvalidArgumentException('Min value is not defined for aggregation function: ' . get_class($aggregationFunction));
    }

    /**
     * @param AggregationFunction $aggregationFunction
     * @param SoftwareTool|null $softwareTool
     * @return float|int
     */
    public static function getMaxValueForAggregateAll(AggregationFunction $aggregationFunction, SoftwareTool $softwareTool = null)
    {
        if ($aggregationFunction instanceof GeometricMean || $aggregationFunction instanceof ArithmeticMean) {
            return Answer::MAX_VALUE;
        }

        $respondents = Respondent::all();

        $answersCount = new Collection();
        /** @var Respondent $respondent */
        foreach ($respondents as $respondent) {
            $answers = $respondent->answers();

            if ($softwareTool != null) {
                $answers->where('software_tool_id', '=', $softwareTool->id);
            }

            $answersCount->add($answers->get()->count());
        }

        if ($aggregationFunction instanceof Sum) {
            return Answer::MAX_VALUE * $answersCount->max(); // MAX_VALUE * max(count of answered questions per respondent)
        }

        throw new \InvalidArgumentException('Max value is not defined for aggregation function: ' . get_class($aggregationFunction));
    }
}
