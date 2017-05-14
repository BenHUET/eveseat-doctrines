<?php

namespace Seat\Kassie\Doctrines\Http\Controllers;

use Illuminate\Http\Request;

use Seat\Web\Http\Controllers\Controller;

use Seat\Kassie\Doctrines\Models\Category;

class CategoryController extends Controller
{

	public function manage()
	{	
		$categories = Category::all()->sortBy('name');
		return view('doctrines::category.manage', [
			'categories' => $categories
		]);
	}

	public function store(Request $request)
	{	
		$this->validate($request, [
			'name' => 'required|string|unique:doctrines_fit_category|max:255'
		]);

		$category = new Category($request->all());
		$category->save();

		return redirect()->back();
	}

	public function delete(Request $request) 
	{
		$this->validate($request, [
			'id' => 'exists:doctrines_fit_category'
		]);

		Category::destroy($request->id);

		return redirect()->back();
	}

	public function update(Request $request) 
	{
		$this->validate($request, [
			'id' => 'exists:doctrines_fit_category',
			'name' => 'required|string|unique:doctrines_fit_category|max:255'
		]);

		$category = Category::find($request->id);
		$category->name = $request->name;
		$category->save();

		return redirect()->back();
	}

}