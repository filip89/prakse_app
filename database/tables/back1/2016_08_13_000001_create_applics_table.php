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
			$table->integer("user_id")->unsigned();
			$table->integer("academic_year");
			$table->string("department", 100);
			$table->integer("average_bacc_grade");
			$table->integer("average_master_grade");
			$table->string("desired company", 100);
			$table->string("residence_town", 100);
			$table->string("residence_county", 100);
			$table->string("internship_town", 100);
			$table->string("internship_month", 100);
            $table->timestamps();
        });
		
		Schema::table('applics', function ($table){
			$table->foreign("user_id")->references("id")->on("users");
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
