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
		return $this->belongsToMany(InvType::class, 'doctrines_fit_inv_type')->withPivot('state', 'qty');
	}

	public function fitted() 
	{
		return $this->belongsToMany(InvType::class, 'doctrines_fit_inv_type')
					->where('state', 'fitted')
					->withPivot('qty');
	}

	public function on_board() 
	{
		return $this->belongsToMany(InvType::class, 'doctrines_fit_inv_type')
					->wherePivot('state', 'on-board')
					->withPivot('qty');
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
		$charges = $this->inv_types->where('inv_group.inv_category.categoryName', 'Charge');
		$drones = $this->fitted->where('inv_group.inv_category.categoryName', 'Drone');

		foreach ($this->racks as $rack) {
			$lines[] = '';
			for ($i = 0; $i < $this->layout->get($rack); $i++) {
				foreach ($modules as $module) {
					if ($module->slot == $rack) {
						for ($qty = 0; $qty < $module->pivot->qty; $qty++) {
							$lines[] = $module->typeName;
						}
						$modules = $modules->except([$module->typeID]);
						break;
					}
				}
			}
		}

		foreach ($drones as $drone) {
			$lines[] = $drone->typeName . ' x' . $drone->pivot->qty;
		}

		if ($drones)
			$lines[] = '';

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
		return $this->inv_types->where('inv_group.inv_category.categoryName', 'Drone');
	}

	// Swap extra modules/subsystems/rigs to cargo
	public function rearrange() {
		foreach ($this->racks as $rack) {
			$slot_count = $this->layout->get($rack);
			$modules = $this->fitted->where('slot', $rack);
			$kept = 0;
			
			foreach ($modules as $module) {
				if ($kept < $slot_count) {
					if ($module->pivot->qty + $kept <= $slot_count) {
						$kept += $module->pivot->qty;
					}
					else {
						$qtyToSwap = min($module->pivot->qty - $slot_count - $kept, $slot_count - $kept);

						$this->inv_types()->updateExistingPivot($module->typeID, ['state' => 'fitted', 'qty' => $module->pivot->qty - $qtyToSwap]);
						$this->inv_types()->attach($module->typeID, ['state' => 'on-board', 'qty' => $qtyToSwap]);

						$kept += $module->pivot->qty;
					}
				}
				else {
					$this->inv_types()->updateExistingPivot($module->typeID, ['state' => 'on-board']);
				}
			}
		}
	}

}
