<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vlans', function(Blueprint $table)
		{
			$table->increments('vlan_id');
			$table->string('subnet');
			$table->integer('office_id')->unsigned();
			$table->timestamps();
			$table->foreign('office_id')->references('office_id')->on('offices')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vlans');
	}

}
