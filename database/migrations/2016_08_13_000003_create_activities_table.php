<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
			$table->increments('id');
			$table->integer("applic_id")->unsigned();
			$table->integer("number");
			$table->string("year", 50)->nullable();
			$table->string("description", 5000)->nullable();
            $table->timestamps();
        });
		
		Schema::table('activities', function($table) {
			$table->foreign("applic_id")->references("id")->on("applics")->onDelete("cascade");
		});
		
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('activities');
    }
}
