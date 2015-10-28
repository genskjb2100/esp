<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedules', function(Blueprint $table)
		{
			$table->increments('schedule_id');
			$table->boolean('flexi');
			$table->time('mon_start');
			$table->time('mon_stop');
			$table->time('tue_start');
			$table->time('tue_stop');
			$table->time('wed_start');
			$table->time('wed_stop');
			$table->time('thu_start');
			$table->time('thu_stop');
			$table->time('fri_start');
			$table->time('fri_stop');
			$table->time('sat_start');
			$table->time('sun_stop');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->integer('grace_period_id')->unsigned();
			$table->foreign('grace_period_id')->references('grace_period_id')->on('grace_periods');
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
		Schema::drop('schedules');
	}

}
