<?php

return [
	'doctrines' => [
		'name'          => 'doctrines',
		'label'         => 'doctrines::meta.plugin_name',
		'icon'          => 'fa-cubes',
		'route_segment' => 'doctrines',
		'permission' => 'doctrines.view',
		'entries' => [
			[
				'name'  => 'Doctrines',
				'icon'  => 'fa-cube',
				'route' => 'doctrine.index',
				'permission' => 'doctrines.view',
				'entries' => [
					[
						'name'  => 'All',
						'icon'  => 'fa-th-list',
						'route' => 'doctrine.index',
						'permission' => 'doctrines.view'
					],
					[
						'name'  => 'Create',
						'icon'  => 'fa-plus',
						'route' => 'doctrine.index',
						'permission' => 'doctrines.createDoctrine'
					]
				]
			],
			[
				'name'  => 'Fits',
				'icon'  => 'fa-space-shuttle',
				'route' => 'doctrine.index',
				'permission' => 'doctrines.view',
				'entries' => [
					[
						'name'  => 'All',
						'icon'  => 'fa-th-list',
						'route' => 'doctrine.index',
						'permission' => 'doctrines.view'
					],
					[
						'name'  => 'Create',
						'icon'  => 'fa-plus',
						'route' => 'doctrine.index',
						'permission' => 'doctrines.createFit'
					]
				]
			],
			[
				'name'  => 'Settings',
				'icon'  => 'fa-cog',
				'route' => 'doctrine.index',
				'permission' => 'doctrines.setup'
			]
		]
	]
];