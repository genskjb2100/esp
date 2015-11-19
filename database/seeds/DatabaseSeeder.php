<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call(RoleTableSeeder::class);
		$this->call(OfficesTableSeeder::class);
		$this->call(GracePeriodsTableSeeder::class);
		$this->call(StatusesTableSeeder::class);
		$this->call(VlansTableSeeder::class);
		$this->call(ModuleTableSeeder::class);
		$this->call(IpcamsTableSeeder::class);
		$this->call(UsersTableSeeder::class);
	}

}
