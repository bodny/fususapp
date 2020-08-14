<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class RespondentGroupSoftwareTool
 * @package App
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class RespondentGroupSoftwareTool extends Pivot
{
    protected $table = 'respondent_group_software_tool';

    public $timestamps = false;

}
