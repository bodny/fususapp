<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateRespondentGroupSoftwareToolPivotTable
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class CreateRespondentGroupSoftwareToolPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respondent_group_software_tool', function (Blueprint $table) {
            $table->bigInteger('respondent_group_id')->unsigned()->index();
            $table->foreign('respondent_group_id')->references('id')->on('respondent_groups')->onDelete('cascade');
            $table->bigInteger('software_tool_id')->unsigned()->index();
            $table->foreign('software_tool_id')->references('id')->on('software_tools')->onDelete('cascade');
            $table->primary(['respondent_group_id', 'software_tool_id'], 'respondent_group_software_tool_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respondent_group_software_tool');
    }
}
