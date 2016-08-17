<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollegeMentorFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_mentor_field', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('field_id')->unsigned()->nullable();
			$table->integer("college_mentor_id")->unsigned()->nullable();
            $table->timestamps();
        });
		
		Schema::table('college_mentor_field', function ($table){
			$table->foreign("college_mentor_id")->references("id")->on("college_mentors")->onDelete("cascade");
			$table->foreign("field_id")->references("id")->on("fields")->onDelete("cascade");
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("college_mentor_field");
    }
}
