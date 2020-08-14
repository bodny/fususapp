<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Answer
 * @package App
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class Answer extends Model
{
    public const DISAGREE = 1;
    public const RATHER_DISAGREE = 2;
    public const CANNOT_JUDGE = 3;
    public const RATHER_AGREE = 4;
    public const AGREE = 5;

    public const MIN_VALUE = 1;
    public const MAX_VALUE = 5;

    public function respondent()
    {
        return $this->belongsTo('App\Respondent');
    }

    public function softwareTool()
    {
        return $this->belongsTo('App\SoftwareTool');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
