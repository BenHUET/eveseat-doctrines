<?php

namespace Seat\Kassie\Doctrines\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;

class DoctrineController extends Controller
{
	public function index()
	{	
		return view('doctrines::doctrine.index', []);
	}
}