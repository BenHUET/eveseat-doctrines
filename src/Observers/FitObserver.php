<?php

namespace Seat\Kassie\Doctrines\Observers;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

use Seat\Kassie\Doctrines\Models\Fit;

class FitObserver
{
	public function creating(Fit $fit)
	{
		$fit->owner()->associate(auth()->user());
	}

	public function updating(Fit $fit)
	{
		$fit->updater()->associate(auth()->user());
	}
}