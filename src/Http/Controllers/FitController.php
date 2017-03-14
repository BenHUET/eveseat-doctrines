<?php

namespace Seat\Kassie\Doctrines\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;

class FitController extends Controller
{
	public function index()
	{	
		return view('doctrines::fit.index', []);
	}

	public function indexStore()
	{
		return view('doctrines::fit.create', []);
	}
}