<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 * @package App
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class Company extends Model
{
    public function respondentGroups()
    {
        return $this->hasMany('App\RespondentGroup');
    }
}
