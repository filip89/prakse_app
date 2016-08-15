<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityApplicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_applic', function (Blueprint $table) {
			$table->increments('id');
			$table->integer("applic_id")->unsigned();
			$table->integer("activity_id")->unsigned();
            $table->timestamps();
        });
		
		Schema::table('activity_applic', function ($table){
			$table->foreign("applic_id")->references("id")->on("applics");
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
        Schema::drop('activity_applic');
    }
}
