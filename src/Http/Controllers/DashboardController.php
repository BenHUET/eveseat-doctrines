<?php

namespace Seat\Kassie\Doctrines\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Seat\Web\Http\Controllers\Controller;

class DashboardController extends Controller
{
	public function index()
	{	
		$permissions = [
			'doctrine' => auth()->user()->has('doctrines.manageDoctrine', false),
			'fit' => auth()->user()->has('doctrines.manageFit', false),
			'category' => auth()->user()->has('doctrines.manageCategory', false)
		];

		return view('doctrines::dashboard.index', [
			'permissions' => $permissions
		]);
	}
}