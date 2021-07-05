<?php

namespace Database\Seeders;

use App\Clients\Client;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		Client::factory(10)->create();
	}
}
