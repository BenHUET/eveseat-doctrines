<?php

Route::group([
	'namespace' => 'Seat\Kassie\Doctrines\Http\Controllers',
	'middleware' => ['web', 'bouncer:doctrines.view'],
	'prefix' => 'doctrines'
], function () {

	// Doctrines
	Route::group([
		'prefix' => 'doctrine'
	], function() {

		Route::get('index', [
			'as' => 'doctrines.doctrine.index',
			'uses' => 'DoctrineController@index',
		]);

		Route::get('create', [
			'as' => 'doctrines.doctrine.indexStore',
			'uses' => 'DoctrineController@indexStore',
			'middleware' => 'bouncer:doctrines.createDoctrine',
		]);

	});

	// Fits
	Route::group([
		'prefix' => 'fit'
	], function() {

		Route::get('index', [
			'as' => 'doctrines.fit.index',
			'uses' => 'FitController@index',
		]);

		Route::get('create', [
			'as' => 'doctrines.fit.indexStore',
			'uses' => 'FitController@indexStore',
			'middleware' => 'bouncer:doctrines.createFit',
		]);

	});

});