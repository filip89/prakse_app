<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternMentorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intern_mentors', function (Blueprint $table) {
            $table->increments('id');
			$table->integer("user_id")->unsigned();
			$table->string('job_description')->nullable();
			$table->string('phone')->nullable();
			$table->integer('company_id')->unsigned()->nullable();
            $table->timestamps();
        });
		
		Schema::table('intern_mentors', function ($table){
			$table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
			$table->foreign("company_id")->references("id")->on("companies");
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("intern_mentors");
    }
}
