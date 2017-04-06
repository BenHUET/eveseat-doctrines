<?php

namespace Seat\Kassie\Doctrines\Helpers;

use Illuminate\Support\Facades\DB;
use Seat\Kassie\Doctrines\Exceptions\DoctrinesFitParseException;

use Seat\Kassie\Doctrines\Models\SDE\InvType;
use Seat\Kassie\Doctrines\Models\SDE\DgmTypeAttribute;

class ParserEFT
{

	public static function Parse($raw) {
		$fit = [
			'items' => array()
		];

		$first = true;

		/* http://stackoverflow.com/a/1462759 */
		foreach(preg_split("/((\r?\n)|(\r\n?))/", $raw) as $line) {
			if ($first) {
				$header = self::parseHeader($line);
				$fit['ship'] = $header['ship'];
				$fit['title'] = $header['title'];
				$first = false;
			}
			else {
				$fit['items'][] = self::parseItem($line);
			}
		}

		return $fit;
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
			$result['ship'] = [
				'id' => $query->typeID,
				'name' => $query->typeName,
				'layout' => [
					'low' => $query->dgm_type_attributes->where('attributeID', '12')->first()->value,
					'med' => $query->dgm_type_attributes->where('attributeID', '13')->first()->value,
					'high' => $query->dgm_type_attributes->where('attributeID', '14')->first()->value,
					'rig' => $query->dgm_type_attributes->where('attributeID', '1137')->first()->value
				]
			];
		}
		else {
			throw new DoctrinesFitParseException("Invalid ship.");
		}
		
		$result['title'] = $title;

		return $result;
	}

	private static function parseItem($line) {
		$res = ['qty' => 1];
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
				$res['qty'] = (int)$last;
				$item = str_replace("x" . $last, "", $item);
			}
		}

		$item_query = InvType::where('typeName', '=', $item)->first();

		if ($item_query) {
			$cat = strtolower($item_query->inv_group->inv_category->categoryName);

			$res['type'] = $cat;
			$res[$cat] = [
				'id' => $item_query->typeID,
				'name' => $item_query->typeName,
			];

			if ($cat == 'module') {
				$res['slot'] = self::effectIDToHuman($item_query->dgm_type_effects->whereIn('effectID', [11, 12, 13, 2663])->first()->effectID);
			}
			
			if ($charge) {
				$charge_query = InvType::where('typeName', '=', $charge)->first();
				if ($charge_query && $charge_query->inv_group->inv_category->categoryName == 'Charge')  {
					$res['charge'] = [
						'id' => $charge_query->typeID,
						'name' => $charge_query->typeName
					];
				}
				else {
					throw new DoctrinesFitParseException('Charge "' . $charge . '" not found.');
				}
			}
		}
		else {
			throw new DoctrinesFitParseException('Item "' . $item . '" not found.');
		}

		return $res;
	}

	private static function effectIDToHuman($effectID) {
		switch ($effectID) {
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