<?php

namespace Seat\Kassie\Doctrines\Helpers;

class SDEHelper
{
	public static function attributeIDToHuman($id) {
		switch ($id) {
			case 12:
			case 1376:
				return 'low';
			case 13:
			case 1375:
				return 'med';
			case 14:
			case 1374:
				return 'high';
			case 1137:
				return 'rig';
		}

		return null;
	}

	public static function effectIDToHuman($id) {
		switch ($id) {
			case 11:
				return 'low';
			case 12:
				return 'high';
			case 13:
				return 'med';
			case 2663:
				return 'rig';
		}

		return null;
	}

}