<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
	 * 0 - nepotvrđena za taj natječaj, 1 - potvrđena za taj natječaj
	 *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
        	$table->increments('id');
		$table->string("name", 100)->nullable();
		$table->string('email')->unique()->nullable();
		$table->string('phone', 100)->nullable();
		$table->string('residence', 100)->nullable();
		$table->string('field', 50)->nullable();
		$table->integer('spots');
		$table->integer('status')->default(1);
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
        Schema::drop("companies");
    }
}
