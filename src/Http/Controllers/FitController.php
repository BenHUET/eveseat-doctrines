<?php

namespace Seat\Kassie\Doctrines\Http\Controllers;

use Illuminate\Http\Request;

use Seat\Web\Http\Controllers\Controller;

use Seat\Kassie\Doctrines\Models\Fit;
use Seat\Kassie\Doctrines\Exceptions\DoctrinesFitParseException;

use Seat\Kassie\Doctrines\Helpers\ParserEFT;

class FitController extends Controller
{

	public function index()
	{	
		return view('doctrines::fit.index', []);
	}

	public function indexStore()
	{
		$fit = null;
		$err = null;

		if (session()->has('fit')) {
			try {
				$fit = ParserEFT::Parse(session('fit'), 'fitted');
				// $cargo = ParserEFT::Parse(session('cargo'), 'onboard');
			}
			catch (DoctrinesFitParseException $e) {
				$err = $e->getMessage();
			}
			catch (DoctrinesItemNotAModuleException $e) {
				$err = $e->getMessage();
			}
			session()->forget('fit');
			session()->forget('cargo');
		}

		return view('doctrines::fit.create', [
			'err' => $err,
			'fit' => $fit
		]);
	}

	public function indexStorePreview(Request $request)
	{
		session([
			'fit' => $request->eft,
			'cargo' => $request->cargo
		]);
		return redirect()->route('doctrines.fit.indexStore');
	}

}