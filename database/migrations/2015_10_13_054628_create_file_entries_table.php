<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileEntriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('file_entries', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('filename');
			$table->string('original_filename');
			$table->string('mime');
			$table->timestamps();
			$table->integer('profile_id')->unsigned();
			$table->foreign('profile_id')->references('profile_id')->on('profiles')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('file_entries');
	}

}
