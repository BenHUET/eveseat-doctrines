<?php

namespace Seat\Kassie\Doctrines\Seeders;

use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
	public function run()
	{
		$job = [
			'command'           => 'doctrines:purge-fit',
			'expression'        => '00 00 * * *',
			'allow_overlap'     => false,
			'allow_maintenance' => false,
			'ping_before'       => null,
			'ping_after'        => null
		];

		$existing = \DB::table('schedules')
			->where('command', $job['command'])
			->where('expression', $job['expression'])
			->first();

		if (!$existing) {
			\DB::table('schedules')->insert($job);
		}
	}
}