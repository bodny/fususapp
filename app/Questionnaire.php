<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Questionnaire
 * @package App
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class Questionnaire extends Model
{
    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function respondentGroups()
    {
        return $this->hasMany('App\RespondentGroup');
    }
}
