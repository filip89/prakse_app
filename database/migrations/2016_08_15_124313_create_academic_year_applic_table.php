<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicYearApplicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
        public function up()
    {
        Schema::create('academic_year_applic', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('applic_id')->unsigned();
            $table->integer('academic_year_id')->unsigned();
            
        });

        Schema::table('academic_year_applic', function($table) {
            $table->foreign('applic_id')->references('id')->on('applics')->onDelete("cascade");
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('academic_year_applic');
    }
}
