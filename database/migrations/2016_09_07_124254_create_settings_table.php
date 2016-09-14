<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
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
        Schema::create('settings', function (Blueprint $table) {
        	$table->increments('id');
			$table->integer("status");
			$table->string("name", 100);
			$table->integer("internships_available")->nullable();
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
        Schema::drop('settings');
    }
}
