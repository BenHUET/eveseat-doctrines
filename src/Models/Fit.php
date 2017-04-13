<?php

namespace Seat\Kassie\Doctrines\Models;

use DB;
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

	public function getDronesAttribute() {
		return $this->fitted()->whereIn('inv_group.inv_category.categoryName', ['Drone', 'Fighter']);
	}

	public function getChargesAttribute() {
		return $this->inv_types()->where('inv_group.inv_category.categoryName', 'Charge');
	}

	public function getInvTypesSortedAttribute() {
		return $this->getSortedCollection($this->inv_types(), 'inv_types');
	}

	public function getFittedSortedAttribute() {
		return $this->getSortedCollection($this->fitted(), 'fitted');
	}

	public function getOnBoardSortedAttribute() {
		return $this->getSortedCollection($this->on_board(), 'on_board');
	}

	public function getDronesSortedAttribute() {
		return $this->fitted_sorted->whereIn('inv_group.inv_category.categoryName', ['Drone', 'Fighter']);
	}

	public function getChargesSortedAttribute() {
		return $this->on_board_sorted->where('inv_group.inv_category.categoryName', 'Charge');
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
		foreach ($this->racks as $rack) {
			$suitables = $modules->where('slot', $rack);
			$suitables_count = $suitables->count();

			if ($suitables_count > 0)
				$lines[] = '';

			for ($i = 0; $i < $this->layout->get($rack); $i++) {
				if ($i < $suitables_count) {
					$lines[] = $suitables->shift()->typeName;
				}
				else {
					$lines[] = '[Empty ' . ucfirst($rack) . ' slot]';
				}
			}
		}

		if ($this->drones_sorted->count() > 0) {
			$lines[] = '';
			foreach ($this->drones_sorted as $drone) {
				$lines[] = $drone->typeName . ' x' . $drone->stack_qty;
			}
		}

		if ($this->charges_sorted->count() > 0) {
			$lines[] = '';
			foreach ($this->charges_sorted as $charge) {
				$lines[] = $charge->typeName . ' x' . $charge->stack_qty;
			}
		}

		$cargo = $this->on_board_sorted;
		if ($cargo) {
			$lines[] = '';
			foreach ($cargo as $item) {
				if ($item->inv_group->inv_category->categoryName != 'Charge' 
					&& $item->inv_group->inv_category->categoryName != 'Drone' 
					&& $item->inv_group->inv_category->categoryName != 'Fighter')
					$lines[] = $item->typeName . ' x' . $item->stack_qty;
			}
		}

		return join(" \r\n", $lines);
	}

	public function getMultibuyAttribute() {
		$lines = array();

		$lines[] = '1x ' . $this->ship->typeName;
		
		$items = $this->inv_types_sorted;
		foreach($items as $item) {
			$lines[] = $item->stack_qty . 'x ' . $item->typeName;
		}

		return join(" \r\n", $lines);
	}

	// Swap extra modules/subsystems/rigs to cargo
	public function rearrange() {
		foreach ($this->racks as $rack) {
			$slot_count = $this->layout->get($rack);
			$modules = $this->fitted->where('slot', $rack);
			$kept = 0;
			
			foreach ($modules as $module) {
				if ($kept + 1 > $slot_count) {
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
		$category = $item['inv_group']['inv_category']['categoryName'];

		if ($category == 'Module' || $category == 'Subsystem') {
			if ($item['slot']) {
				if ($item['slot'] == 'high')
					return 1;
				if ($item['slot'] == 'med')
					return 2;
				if ($item['slot'] == 'low')
					return 3;
				if ($item['slot'] == 'subsystem')
					return 4;
				if ($item['slot'] == 'rig')
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

	private function getSortedCollection($input, $identifier) {
		$collection = $input->select('*', DB::raw('sum(doctrines_fit_inv_type.qty) as stack_qty'))
			->groupBy('typeID')
			->get()
			->sortBy(function ($item, $key) { return $this->sortItems($item, $key); });

		return $collection;
	}

}
