<?php

namespace Seat\Kassie\Doctrines\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Seat\Kassie\Doctrines\Exceptions\DoctrinesFitParseException;

use Seat\Kassie\Doctrines\Models\SDE\InvType;
use Seat\Kassie\Doctrines\Models\Fit;

class ParserEFT
{
	private static $fit;

	public static function Parse($raw_fit, $raw_cargo = null) {
		$raw_fit = trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $raw_fit));
		$raw_cargo = trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $raw_cargo));

		self::$fit = new Fit;

		$first = true;
		/* http://stackoverflow.com/a/1462759 */
		foreach(preg_split("/((\r?\n)|(\r\n?))/", $raw_fit) as $line) {
			if ($first) {
				self::parseHeader($line);
				self::$fit->save();
				$first = false;
			}
			else {
				if (strpos($line, '[Empty') === false)
					self::parseItem($line, 'fitted');
			}
		}

		if ($raw_cargo) {
			foreach(preg_split("/((\r?\n)|(\r\n?))/", $raw_cargo) as $line) {
				self::parseItem($line, 'on-board');
			}
		}

		self::$fit->rearrange();

		self::$fit->push();

		return self::$fit;
	}

	private static function parseHeader($line) {
		$result = array();
		$ship = trim($line, '[]');
		$title = null;

		if (strpos($ship, ',') !== false) {
			$parts = explode(',', $ship);
			$title = str_replace($parts[0] . ',', "", $ship);
			$ship = trim($parts[0]);
		}

		$query = InvType::whereHas('inv_group.inv_category', function ($query) {
			$query->where('categoryName', '=', 'Ship');
		})
		->where('typeName', '=', $ship)
		->first();

		if ($query && strlen($ship) > 0) {
			self::$fit->ship()->associate($query);
		}
		else {
			throw new DoctrinesFitParseException("Invalid ship.");
		}
		
		self::$fit->name = $title ?: auth()->user()->name . "'s " . $query->typeName;
	}

	private static function parseItem($line, $state) {
		$qty = 1;
		$item = $line;
		$charge = null;
		$item_state = $state;

		if (strpos($line, ',') !== false) {
			$parts = explode(',', $line);
			$item = trim($parts[0]);
			$charge = trim($parts[1]);
		}

		$parts = explode('x', $item);
		$last = $parts[count($parts) - 1];
		if (is_numeric($last)) {
			$qty = (int)$last;
			$item = str_replace("x" . $last, "", $item);
		}

		if ($charge && $qty > 1)
			throw new DoctrinesFitParseException("EFT bad format. Quantities and charges are not allowed on the same line. Line : '" . $line . "'");

		$queries = array();

		$queries[0] = InvType::where('typeName', '=', $item)->first();
		if ($charge)
			$queries[1] = InvType::where('typeName', '=', $charge)->first();

		if (!$queries[0] || ($charge && !$queries[1])) {
			throw new DoctrinesFitParseException('Item "' . $item . '" not found.');
		}

		for ($i = 0; $i < count($queries); $i++) {
			$query = $queries[$i];
			$item_state = $state;

			if ($i == 1) { // If loaded charge
				$module_capacity = $queries[0]->capacity;
				$charge_volume = $query->volume;
				$qty = $module_capacity / $charge_volume;
			}

			if ($qty > 1)
				$item_state = 'on-board';

			if (in_array($query->inv_group->inv_category->categoryName, ['Drone', 'Fighter', 'Implant']))
				$item_state = 'fitted';

			if ($state == 'fitted'
					&& !in_array($query->inv_group->inv_category->categoryName, ['Module', 'Subsystem', 'Fighter', 'Drone', 'Implant']))
				$item_state = 'on-board';

			if ($query->inv_group->groupName == 'Booster')
				$item_state = 'on-board';


			self::$fit->inv_types()->attach($query->typeID, ['state' => $item_state, 'qty' => $qty]);
		}
	}

}