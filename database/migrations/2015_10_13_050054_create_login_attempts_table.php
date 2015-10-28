<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginAttemptsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('login_attempts', function(Blueprint $table)
		{
			$table->increments('login_attempt_id');
			$table->string('attempt_status');
			$table->string('ip');
			$table->integer('attempts');
			$table->string('username');
			$table->timestamp('failed_last_login');
			$table->timestamp('success_last_login');
			$table->string('login_page_name');
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
		Schema::drop('login_attempts');
	}

}
