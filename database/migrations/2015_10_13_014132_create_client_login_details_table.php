<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientLoginDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('client_login_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('ip');
			$table->string('external_ip');
			$table->string('client_email');
			$table->string('browser');
			$table->string('os');
			$table->string('screen_width');
			$table->string('screen_height');
			$table->string('country');
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
		Schema::drop('client_login_details');
	}

}
