<?php

namespace Seat\Kassie\Doctrines\Models;

use Illuminate\Database\Eloquent\Model;

use Seat\Kassie\Doctrines\Models\SDE\InvType;

use Seat\Kassie\Doctrines\Helpers\SDEHelper;

class Fit extends Model
{
	protected $table = 'doctrines_fits';
	protected $fillable = [
		'name',
		'published',
		'sane',
		'comment'
	];

	private $racks = ['high', 'low', 'med', 'rig', 'subsystem'];

	public function ship() {
		return $this->belongsTo(InvType::class, 'ship_id', 'typeID');
	}

	public function inv_types()
	{
		return $this->belongsToMany(InvType::class, 'doctrines_fit_inv_type', 'fit_id', 'inv_type_id')->withPivot('id', 'qty', 'state');
	}

	public function fitted() 
	{
		return $this->inv_types()->wherePivot('state', 'fitted');
	}

	public function on_board() 
	{
		return $this->inv_types()->wherePivot('state', 'on-board');
	}

	public function getOnBoardSortedAttribute() {
		return $this->on_board->sortBy(function ($item, $key) { 
				return $this->sortItems($item, $key);
			})
			->values()
			->all();
	}

	public function getFittedSortedAttribute() {
		return $this->fitted->sortBy(function ($item, $key) { 
				return $this->sortItems($item, $key);
			})
			->values()
			->all();
	}

	public function getLayoutAttribute()
	{
		$layout = [
			'high' => 0,
			'med' => 0,
			'low' => 0,
			'rig' => 0,
			'subsystem' => 0
		];

		foreach([12, 13, 14, 1137] as $id) {
			$attr = $this->ship->dgm_type_attributes->where('attributeID', $id);
			$qty = $attr->first() ? $attr->first()->value : 0;
			$rack = SDEHelper::attributeIDToHuman($id);
			$layout[$rack] = $qty;
		}

		$subsystems = $this->inv_types->where('pivot.state', 'fitted')->where('inv_group.inv_category.categoryName', 'Subsystem');

		if ($subsystems->isNotEmpty()) {
			$layout['subsystem'] = 5;

			foreach($subsystems as $subsystem) {
				foreach([1374, 1375, 1376] as $id) {
					$attr = $subsystem->dgm_type_attributes->where('attributeID', $id);
					$qty = $attr->first() ? $attr->first()->value : 0;
					$rack = SDEHelper::attributeIDToHuman($id);
					$layout[$rack] += $qty;
				}
			}
		}

		return collect($layout);
	}

	public function getEftAttribute() {
		$lines = array();

		$header = '[' . $this->ship->typeName;
		if ($this->name)
			$header .= ', '  . $this->name;
		$header .= ']';

		$lines[] = $header;

		$modules = $this->fitted->whereIn('inv_group.inv_category.categoryName', ['Module', 'Subsystem']);
		$charges = $this->on_board->where('inv_group.inv_category.categoryName', 'Charge');

		foreach ($this->racks as $rack) {
			$lines[] = '';
			for ($i = 0; $i < $this->layout->get($rack); $i++) {
				foreach ($modules->where('slot', $rack) as $module) {
					for ($qty = 0; $qty < $module->pivot->qty; $qty++) {
						$lines[] = $module->typeName;
					}

					$modules = $modules->except([$module->typeID]);
					break;
				}
			}
		}

		foreach ($this->drones as $drone) {
			$lines[] = $drone->typeName . ' x' . $drone->pivot->qty;
		}

		foreach ($charges as $charge) {
			$lines[] = $charge->typeName . ' x' . $charge->pivot->qty;
		}

		return join(" \r\n", $lines);
	}

	public function getMultibuyAttribute() {
		$lines = array();

		$lines[] = '1x ' . $this->ship->typeName;
		
		$items = $this->inv_types->all();
		foreach($items as $item) {
			$lines[] = $item->pivot->qty . 'x ' . $item->typeName;
		}

		return join(" \r\n", $lines);
	}

	public function getDronesAttribute() {
		return $this->inv_types->whereIn('inv_group.inv_category.categoryName', ['Drone', 'Fighter']);
	}

	// Swap extra modules/subsystems/rigs to cargo
	public function rearrange() {
		foreach ($this->racks as $rack) {
			$slot_count = $this->layout->get($rack);
			$modules = $this->fitted->where('slot', $rack);
			$kept = 0;
			
			foreach ($modules as $module) {
				if ($kept + 1 > $slot_count) {
					// $module->pivot->state = "on-board";
					$this->inv_types()
						->newPivotStatement()
						->where('id', $module->pivot->id)
						->update(['state' => 'on-board']);
				}
				$kept++;
			}
		}
	}

	private function sortItems($item, $key) {
		$category = $item->inv_group->inv_category->categoryName;

		if ($category == 'Module' || $category == 'Subsystem') {
			if ($item->slot) {
				if ($item->slot == 'high')
					return 1;
				if ($item->slot == 'med')
					return 2;
				if ($item->slot == 'low')
					return 3;
				if ($item->slot == 'subsystem')
					return 4;
				if ($item->slot == 'rig')
					return 5;
			}
		} 
		else if ($category = 'Drone' || $category = 'Fighter') {
			return 6;
		}
		else if ($category = 'Charge') {
			return 7;
		}

		return 8;
	}

}
