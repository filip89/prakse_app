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
		$table->integer("competition_id")->unsigned();
		$table->integer("academic_year");
		$table->integer("course");
		$table->string("email", 100);
		$table->decimal("average_bacc_grade", 3, 2)->nullable()->default(0);
		$table->decimal("average_master_grade", 3, 2)->nullable()->default(0);
		$table->integer("desired_month")->nullable();
		$table->string("desired_company", 200)->nullable();
		$table->string("residence_town", 100);
		$table->integer("residence_county");
		$table->string("internship_town", 100)->nullable();
		$table->integer("status")->unsigned()->default(1);
       		$table->timestamps();
        });
		
		Schema::table('applics', function ($table){
			$table->foreign("student_id")->references("id")->on("users")->onDelete("cascade");
			$table->foreign("competition_id")->references("id")->on("competitions")->onDelete("cascade");
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
