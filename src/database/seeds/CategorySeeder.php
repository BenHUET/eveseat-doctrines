<?php

namespace Seat\Kassie\Doctrines\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
	public function run()
	{
		\DB::table('doctrines_fit_category')->insert([
			[ 'name' => 'DPS' ],
			[ 'name' => 'Tackle' ],
			[ 'name' => 'Buller' ],
			[ 'name' => 'Booster' ],
			[ 'name' => 'Bridge' ],
			[ 'name' => 'Logistic' ],
			[ 'name' => 'Miner' ],
			[ 'name' => 'EWAR' ],
			[ 'name' => 'Bait' ],
			[ 'name' => 'Cyno' ],
			[ 'name' => 'Scout' ],
			[ 'name' => 'Support' ],
			[ 'name' => 'Hauler' ]
		]);
	}
}