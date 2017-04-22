<?php

namespace Seat\Kassie\Doctrines\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;

use Seat\Kassie\Doctrines\Models\Fit;

class PurgeFit extends Command
{
	protected $signature = 'doctrines:purge-fit';
	protected $description = 'Purge parsed but not saved fits';

	public function __construct()
	{
		parent::__construct();
	}

	public function handle()
	{
		$fits = Fit::where('category_id', null)
			->whereDate('created_at', '<', Carbon::now()->subDay()->toDateTimeString())
			->delete();
	}
}