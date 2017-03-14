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
				'route' => 'doctrines.doctrine.index',
				'permission' => 'doctrines.view',
				'entries' => [
					[
						'name'  => 'All',
						'icon'  => 'fa-th-list',
						'route' => 'doctrines.doctrine.index',
						'permission' => 'doctrines.view'
					],
					[
						'name'  => 'Create',
						'icon'  => 'fa-plus',
						'route' => 'doctrines.doctrine.indexStore',
						'permission' => 'doctrines.createDoctrine'
					]
				]
			],
			[
				'name'  => 'Fits',
				'icon'  => 'fa-space-shuttle',
				'route' => 'doctrines.doctrine.index',
				'permission' => 'doctrines.view',
				'entries' => [
					[
						'name'  => 'All',
						'icon'  => 'fa-th-list',
						'route' => 'doctrines.doctrine.index',
						'permission' => 'doctrines.view'
					],
					[
						'name'  => 'Create',
						'icon'  => 'fa-plus',
						'route' => 'doctrines.doctrine.index',
						'permission' => 'doctrines.createFit'
					]
				]
			],
			[
				'name'  => 'Settings',
				'icon'  => 'fa-cog',
				'route' => 'doctrines.doctrine.index',
				'permission' => 'doctrines.setup'
			]
		]
	]
];