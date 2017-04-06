<?php

namespace Seat\Kassie\Doctrines\Http\Controllers;

use Illuminate\Http\Request;

use Seat\Web\Http\Controllers\Controller;

use Seat\Kassie\Doctrines\Models\Fit;
use Seat\Kassie\Doctrines\Exceptions\DoctrinesFitParseException;

class FitController extends Controller
{

	public function index()
	{	
		return view('doctrines::fit.index', []);
	}

	public function indexStore()
	{
		$pretty_display = null;
		$fit_raw = null;
		$err = null;

		if (session()->has('fit')) {
			$fit_raw = session('fit')->raw;
			try {
				$pretty_display = session('fit')->pretty_display;
			}
			catch (DoctrinesFitParseException $e) {
				$err = $e->getMessage();
			}
			session()->forget('fit');
		}

		// return response()->json($pretty_display);

		return view('doctrines::fit.create', [
			'err' => $err,
			'pretty_display' => $pretty_display,
			'fit_raw' => $fit_raw
		]);
	}

	public function indexStorePreview(Request $request)
	{
		$fit = new Fit();
		$fit->raw = $request->eft;
		session(['fit' => $fit]);
		return redirect()->route('doctrines.fit.indexStore');
	}

}