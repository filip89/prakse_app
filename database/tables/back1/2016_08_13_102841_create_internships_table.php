<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internships', function (Blueprint $table) {
            $table->increments('id');
			$table->integer("student_id")->unsigned();
			$table->integer("intern_mentor_id")->unsigned();
			$table->integer("college_mentor_id")->unsigned();
			$table->integer("mentor_application_id")->unsigned();
			$table->integer("company_id")->unsigned();
			$table->datetime("start_date")->nullable();
			$table->datetime("end_date")->nullable();
			$table->integer("amount")->nullable();
			$table->string("student_comment", 1000)->nullable();
			$table->integer("rating_by_student")->nullable();
			$table->string("intern_mentor_comment", 1000)->nullable();
			$table->string("college_mentor_comment", 1000)->nullable();
			$table->integer("confirmation_student")->default(0);
			$table->integer("confirmation_admin")->default(0);	
            $table->timestamps();
        });
		
		Schema::table('internships', function($table) {
			$table->foreign("student_id")->references("id")->on("users");
			$table->foreign("intern_mentor_id")->references("id")->on("users");
			$table->foreign("college_mentor_id")->references("id")->on("users");
			$table->foreign("mentor_application_id")->references("id")->on("users");
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
        Schema::drop('internships');
    }
}
