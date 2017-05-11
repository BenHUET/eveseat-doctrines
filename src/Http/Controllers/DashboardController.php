<?php

namespace Seat\Kassie\Doctrines\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;

class DashboardController extends Controller
{
	public function index()
	{	
		return view('doctrines::dashboard.index', []);
	}

}