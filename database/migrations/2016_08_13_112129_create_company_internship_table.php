<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyInternshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_internship', function (Blueprint $table) {
            $table->increments('id');
			$table->integer("internship_id")->unsigned();
			$table->integer("company_id")->unsigned();
            $table->timestamps();
        });
		
		Schema::table('company_internship', function ($table){
			$table->foreign("internship_id")->references("id")->on("internships");
			$table->foreign("company_id")->references("id")->on("companies");
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("companies_applics");
    }
}
