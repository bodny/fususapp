<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 * @package App
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class Question extends Model
{
    public const DEFAULT_OPTIONS = [
        Answer::DISAGREE => Answer::DISAGREE,
        Answer::RATHER_DISAGREE => Answer::RATHER_DISAGREE,
        Answer::CANNOT_JUDGE => Answer::CANNOT_JUDGE,
        Answer::RATHER_AGREE => Answer::RATHER_AGREE,
        Answer::AGREE => Answer::AGREE,
    ];

    public function questionnaire()
    {
        return $this->belongsTo('App\Questionnaire');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
}
