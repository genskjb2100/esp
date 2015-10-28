<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gift_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('gift_status');
			$table->integer('user_id');
			$table->integer('gift_id');
			$table->integer('company_id');
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
		Schema::drop('gift_users');
	}

}
