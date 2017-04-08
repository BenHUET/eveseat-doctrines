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

	public function ship() {
		return $this->belongsTo(InvType::class, 'ship_id', 'typeID');
	}

	public function inv_types()
	{
		return $this->belongsToMany(InvType::class, 'doctrines_fit_inv_type')->withPivot('state', 'qty');
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

		$items = $this->inv_types->where('pivot.state', 'fitted');
		$modules = $items->whereIn('inv_group.inv_category.categoryName', ['Module', 'Subsystem']);
		$charges = $items->where('inv_group.inv_category.categoryName', 'Charge');
		$drones = $items->where('inv_group.inv_category.categoryName', 'Drone');

		$racks = ['high', 'low', 'med', 'rig', 'subsystem'];
		foreach ($racks as $rack) {
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

		return join(" \r\n ", $lines);
	}

	public function getMultibuyAttribute() {
		$lines = array();

		$lines[] = '1x ' . $this->ship->typeName;
		
		$items = $this->inv_types->all();
		foreach($items as $item) {
			$lines[] = $item->pivot->qty . 'x ' . $item->typeName;
		}

		return join(" \r\n ", $lines);
	}

	public function getDronesAttribute() {
		$lines = array();
		
		$drones = $this->inv_types->where('inv_group.inv_category.categoryName', 'Drone');
		foreach($drones as $drone) {
			$lines[] = $drone->typeName . ' x' . $drone->pivot->qty;
		}

		return join(" \r\n ", $lines);
	}

}
