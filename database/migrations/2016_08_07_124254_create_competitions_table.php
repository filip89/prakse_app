<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
	 *
	 * status: 0 - not active; 1 - active
	 *
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
        	$table->increments('id');
			$table->integer("status");
			$table->integer("year");
			$table->string("name", 100);
			$table->string("availableMonths", 50)->nullable();
			$table->string("message", 10000);
			$table->datetime("end_date");
			$table->date("results_date")->nullable();
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
        Schema::drop('competitions');
    }
}
