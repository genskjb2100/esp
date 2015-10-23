<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGracePeriodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grace_periods', function(Blueprint $table)
		{
			$table->increments('grace_period_id');
			$table->time('grace_period_value');
			$table->string('display');
			$table->string('grace_period_add_timestamp');
			$table->integer('hours');
			$table->integer('minutes');
			$table->integer('seconds');
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
		Schema::drop('grace_periods');
	}

}
