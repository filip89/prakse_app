<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		 Schema::create('complaints', function (Blueprint $table) {
        	$table->increments('id');
			$table->integer("student_id")->unsigned();
			$table->string("content", 10000);
			$table->string("email", 100);
			$table->integer("status")->default(0);
        	$table->timestamps();
        });
		
		Schema::table('complaints', function($table) {
			$table->foreign("student_id")->references("id")->on("users")->onDelete("cascade");
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('complaints');
    }
}
