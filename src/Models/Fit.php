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

}
