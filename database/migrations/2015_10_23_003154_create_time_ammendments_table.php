<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeAmmendmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('time_ammendments', function(Blueprint $table)
		{
			$table->increments('time_ammendment_id');
			$table->string('status');
			$table->timestamp('original_start');
			$table->timestamp('original_finnish');
			$table->timestamp('ammended_start');
			$table->timestamp('ammended_finish');
			$table->string('user_notes');
			$table->string('hr_comments');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->integer('time_registry_id')->unsigned();
			$table->foreign('time_registry_id')->references('time_registry_id')->on('time_registries');
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
		Schema::drop('time_ammendments');
	}

}
