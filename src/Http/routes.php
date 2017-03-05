<?php

Route::group([
	'namespace' => 'Seat\Kassie\Doctrines\Http\Controllers',
	'middleware' => ['web', 'bouncer:doctrines.view'],
	'prefix' => 'doctrines'
], function () {

	Route::resource('doctrine', 'DoctrineController', [
		'only' => ['index', 'show'],
		'names' => [
			'index' => 'doctrine.index'
		]
	]);

});