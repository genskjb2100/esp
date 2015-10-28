<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username')->unique();
			$table->string('email');
			$table->string('client_email');
			$table->string('client_password', 60);
			$table->string('password', 60);
			$table->string('first_name');
			$table->string('last_name');
			$table->string('skype');
			$table->string('phone');
			$table->string('position');
			$table->string('user_auth');
			$table->string('nickname');
			$table->date('birthdate');
			$table->boolean("hidden");
			$table->boolean("refresh");
			$table->boolean("expand_all");
			$table->boolean("work_from_home");
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
