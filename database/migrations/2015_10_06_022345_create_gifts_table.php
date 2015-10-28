<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gifts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('gift_name', 200)->unique();
			$table->longText('description');
			$table->string('img_path', 200);
			$table->string('img_thumb', 200);
			$table->float('price')->default(0);
			$table->boolean('hidden')->default(FALSE);
			$table->boolean('visible')->default(TRUE);
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
		Schema::drop('gifts');
	}

}
