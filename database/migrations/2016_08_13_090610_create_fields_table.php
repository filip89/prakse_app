<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 
     * Područja koja pokriva college_mentor
     */
	public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
			$table->string("name", 50);
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
        Schema::drop("fields");
    }
}
