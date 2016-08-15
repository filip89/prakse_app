<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicsActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applics_activities', function (Blueprint $table) {
			$table->increments('id');
			$table->integer("applic_id")->unsigned();
			$table->integer("activity_id")->unsigned();
			$table->datetime("date_start")->nullable();
			$table->datetime("date_end")->nullable();
			$table->string("comment", 1000)->nullable();
            $table->timestamps();
        });
		
		Schema::table('applics_activities', function ($table){
			$table->foreign("applic_id")->references("id")->on("users");
			$table->foreign("activity_id")->references("id")->on("activities");
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('applics_activites');
    }
}
