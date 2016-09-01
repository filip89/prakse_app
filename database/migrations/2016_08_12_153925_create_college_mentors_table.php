<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollegeMentorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_mentors', function (Blueprint $table) {
            $table->increments('id');
			$table->string('title')->nullable();
			$table->integer("fields")->nullable();
			$table->integer("user_id")->unsigned();
            $table->timestamps();
        });
		
		Schema::table('college_mentors', function ($table){
			$table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("college_mentors");
    }
}
