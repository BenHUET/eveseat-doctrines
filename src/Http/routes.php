<?php

Route::group([
	'namespace' => 'Seat\Kassie\Doctrines\Http\Controllers',
	'middleware' => ['web', 'bouncer:doctrines.view'],
	'prefix' => 'doctrines'
], function () {

	Route::resource('doctrine', 'DoctrineController', [
		'only' => ['index', 'show'],
		'names' => [
			'index' => 'doctrines.doctrine.index',
			'show' => 'doctrines.doctrine.show'
		],
		'prefix' => 'doctrines'
	]);

	Route::get('create', [
		'as' => 'doctrines.doctrine.indexStore',
		'uses' => 'DoctrineController@indexStore',
		'middleware' => 'bouncer:doctrines.createDoctrine',
		'prefix' => 'doctrines'
	]);

});