<?php

namespace Seat\Kassie\Doctrines\Http\Controllers;

use Illuminate\Http\Request;

use Seat\Web\Http\Controllers\Controller;

class CategoryController extends Controller
{

	public function index()
	{	
		return view('doctrines::category.index', []);
	}

}