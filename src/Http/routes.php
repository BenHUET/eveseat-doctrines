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
			'middleware' => 'bouncer:doctrines.manageDoctrines',
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
			'middleware' => 'bouncer:doctrines.manageFit',
		]);

		Route::post('createPreview', [
			'as' => 'doctrines.fit.indexStorePreview',
			'uses' => 'FitController@indexStorePreview',
			'middleware' => 'bouncer:doctrines.manageFit',
		]);

	});

	// Categories (Fit)
	Route::group([
		'prefix' => 'category'
	], function() {

		Route::get('index', [
			'as' => 'doctrines.category.index',
			'uses' => 'CategoryController@index',
			'middleware' => 'bouncer:doctrines.manageCategory'
		]);

	});

	// Dashboard
	Route::group([
		'prefix' => 'dashboard'
	], function() {

		Route::get('index', [
			'as' => 'doctrines.dashboard.index',
			'uses' => 'DashboardController@index',
			'middleware' => 'bouncer:doctrines.viewDashboard'
		]);

	});

});