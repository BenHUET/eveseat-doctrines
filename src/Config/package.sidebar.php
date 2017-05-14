<?php

return [
	'doctrines' => [
		'name'          => 'doctrines',
		'label'         => 'doctrines::meta.plugin_name',
		'icon'          => 'fa-cubes',
		'route_segment' => 'doctrines',
		'permission' => 'doctrines.access',
		'entries' => [
			[
				'name'  => 'Doctrines',
				'icon'  => 'fa-cube',
				'route' => 'doctrines.doctrine.index'
			],
			[
				'name'  => 'Fits',
				'icon'  => 'fa-space-shuttle',
				'route' => 'doctrines.fit.index'
			],
			[
				'name'  => 'Manage',
				'icon'  => 'fa-cog',
				'route' => 'doctrines.dashboard.index',
				'permission' => 'doctrines.viewDashboard'
			]
		]
	]
];