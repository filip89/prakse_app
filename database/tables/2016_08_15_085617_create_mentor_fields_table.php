<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMentorFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentor_fields', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('field_id')->unsigned()->nullable();
			$table->integer("mentor_id")->unsigned()->nullable();
            $table->timestamps();
        });
		
		Schema::table('mentor_fields', function ($table){
			$table->foreign("mentor_id")->references("id")->on("college_mentors")->onDelete("cascade");
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
        Schema::drop("mentor_fields");
    }
}
