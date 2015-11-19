<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permissions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('is_create');
			$table->boolean('is_read');
			$table->boolean('is_update');
			$table->boolean('is_delete');

			$table->boolean('is_archive');
			$table->boolean('is_export');
			$table->boolean('is_import');
			$table->boolean('is_print');
			$table->integer('module_id')->unsigned();
			$table->foreign('module_id')->references('module_id')->on('modules')->onUpdate('cascade');
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
		Schema::drop('permissions');
	}

}
