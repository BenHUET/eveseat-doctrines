<?php

Route::group([
	'namespace' => 'Seat\Kassie\Doctrines\Http\Controllers',
	'middleware' => ['web', 'bouncer:doctrines.access'],
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

		Route::group([
			'middleware' => 'bouncer:doctrines.manageFit',
		], function() {

			Route::get('create', [
				'as' => 'doctrines.fit.indexStore',
				'uses' => 'FitController@indexStore',
			]);

			Route::post('createPreview', [
				'as' => 'doctrines.fit.indexStorePreview',
				'uses' => 'FitController@indexStorePreview',
			]);

		});

	});

	// Categories (Fit)
	Route::group([
		'prefix' => 'category',
	], function() {

		Route::group([
			'middleware' => 'bouncer:doctrines.manageCategory'
		], function() {

			Route::get('manage', [
				'as' => 'doctrines.category.manage',
				'uses' => 'CategoryController@manage',
			]);

			Route::post('store', [
				'as' => 'doctrines.category.store',
				'uses' => 'CategoryController@store',
			]);

			Route::post('delete', [
				'as' => 'doctrines.category.delete',
				'uses' => 'CategoryController@delete',
			]);

			Route::post('update', [
				'as' => 'doctrines.category.update',
				'uses' => 'CategoryController@update',
			]);

		});

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