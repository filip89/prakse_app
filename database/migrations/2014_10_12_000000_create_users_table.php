<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * admin: 
     * 0-not_admin
     * 1-is_admin
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
        	$table->increments('id');
        	$table->string('name', 50);
			$table->string('last_name', 50);
        	$table->string('email')->unique();
			$table->string('phone')->nullable();
        	$table->string('password');
			$table->string('role', 20);
			$table->string('image', 200)->nullable();
			$table->integer('admin')->default(0);
        	$table->rememberToken();
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
        Schema::drop('users');
    }
}
