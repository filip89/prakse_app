<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applics', function (Blueprint $table) {
            $table->increments('id');
			$table->integer("student_id")->unsigned();
			$table->string("academic_year", 50);
			$table->string("department", 50);
			$table->integer("average_bacc_grade");
			$table->integer("average_master_grade")->nullable()->default(0);
			$table->string("desired_company", 100);
			$table->string("desired_month", 100);
			$table->string("residence_town", 100);
			$table->string("residence_county", 100);
			$table->string("internship_town", 100);
            $table->timestamps();
        });
		
		Schema::table('applics', function ($table){
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
        Schema::drop('applics');
    }
}
