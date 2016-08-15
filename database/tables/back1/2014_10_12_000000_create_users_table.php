<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
	 * type = 0-student, 1-intern_mentor, 2-college_mentor
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
			$table->integer('college_mentor')->nullable();
			$table->string('college_mentor_title', 50)->nullable();
			$table->integer('college_mentor_fields')->nullable();
			$table->string('intern_mentor_phone', 50)->nullable();
			$table->string('intern_mentor_email', 50)->nullable();
			$table->string('intern_mentor_work_description', 1000)->nullable();
			$table->integer('intern_mentor_company')->nullable();
			$table->integer('intern_mentor_student')->nullable();
			$table->string('role', 50)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
