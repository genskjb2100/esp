<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailListsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_lists', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('to');
			$table->string('email_status');
			$table->string('to_title');
			$table->string('cc');
			$table->string('cc_title');
			$table->string('bcc');
			$table->string('bcc_title');
			$table->string('from');
			$table->string('from_title');
			$table->string('subject');
			$table->text('body');
			$table->date('send_date');
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
		Schema::drop('email_lists');
	}

}
