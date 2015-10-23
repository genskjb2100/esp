<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeRegistriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('time_registries', function(Blueprint $table)
		{
			$table->increments('time_registry_id');
			$table->string('status');
			$table->timestamp('start_timestamp');
			$table->timestamp('end_timestamp');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->integer('status_id')->unsigned();
			$table->foreign('status_id')->references('status_id')->on('statuses');
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
		Schema::drop('time_registries');
	}

}
