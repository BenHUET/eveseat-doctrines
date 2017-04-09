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
				self::parseItem($line, 'fitted');
			}
		}

		if ($raw_cargo) {
			foreach(preg_split("/((\r?\n)|(\r\n?))/", $raw_cargo) as $line) {
				self::parseItem($line, 'on-board');
			}
		}

		self::$fit->rearrange();

		self::$fit->sane = true;
		self::$fit->save();

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

		if (strpos($line, ',') !== false) {
			$parts = explode(',', $line);
			$item = trim($parts[0]);
			$charge = trim($parts[1]);
		}

		if (!$charge) {
			$parts = explode('x', $item);
			$last = $parts[count($parts) - 1];
			if (is_numeric($last)) {
				$qty = (int)$last;
				$item = str_replace("x" . $last, "", $item);
			}
		}

		$queries = array();

		$queries[0] = InvType::where('typeName', '=', $item)->first();
		if ($charge)
			$queries[1] = InvType::where('typeName', '=', $charge)->first();

		if (!$queries[0] || ($charge && !$queries[1])) {
			throw new DoctrinesFitParseException('Item "' . $item . '" not found.');
		}

		for ($i = 0; $i < count($queries); $i++) {
			$query = $queries[$i];

			if ($i == 1) { // If charge
				$module_capacity = $queries[0]->capacity;
				$charge_volume = $query->volume;
				$qty = $module_capacity / $charge_volume;
			}

			if (self::$fit->inv_types()->find($query->typeID)) {
				$current_qty = self::$fit->inv_types()->find($query->typeID)->pivot->qty;
				self::$fit->inv_types()->updateExistingPivot($query->typeID, ['qty' => ($qty + $current_qty)]);
			}
			else {
				self::$fit->inv_types()->attach($query->typeID, ['state' => $state, 'qty' => $qty]);
			}
		}
	}

}