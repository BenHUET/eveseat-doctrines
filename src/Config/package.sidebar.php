<?php

return [
	'doctrines' => [
		'name'          => 'doctrines',
		'label'         => 'doctrines::meta.plugin_name',
		'icon'          => 'fa-cube',
		'route_segment' => 'doctrines',
		'permission' => 'doctrines.view',
		'entries' => [
			[
				'name'  => 'All doctrines',
				'icon'  => 'fa-th-list',
				'route' => 'doctrine.index',
				'permission' => 'doctrines.view'
			]
		]
	]
];