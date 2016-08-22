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
			$table->integer("intern_mentor_id")->unsigned()->nullable();
			$table->integer("college_mentor_id")->unsigned()->nullable();
			$table->integer("company_id")->unsigned();
			$table->integer("average_bacc_grade");
			$table->integer("average_master_grade")->nullable()->default(0);
			$table->datetime("start_date")->nullable();
			$table->datetime("end_date")->nullable();
			$table->integer("duration")->nullable();
			$table->string("student_comment", 5000)->nullable();
			$table->integer("rating_by_student")->nullable();
			$table->string("intern_mentor_comment", 5000)->nullable();
			$table->string("college_mentor_comment", 5000)->nullable();
			$table->integer("confirmation_student")->nullable()->default(0);
			$table->integer("confirmation_admin")->nullable()->default(0);	
            $table->timestamps();
        });
		
		Schema::table('internships', function($table) {
			$table->foreign("student_id")->references("id")->on("users")->onDelete("cascade");
			$table->foreign("intern_mentor_id")->references("id")->on("users")->onDelete("set null");
			$table->foreign("college_mentor_id")->references("id")->on("users")->onDelete("set null");
			$table->foreign("company_id")->references("id")->on("companies")->onDelete("cascade");
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
