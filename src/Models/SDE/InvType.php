<?php

namespace Seat\Kassie\Doctrines\Models\SDE;

use Illuminate\Database\Eloquent\Model;

use Seat\Kassie\Doctrines\Exceptions\DoctrinesItemNotAModuleException;

use Seat\Kassie\Doctrines\Models\Fit;
use Seat\Kassie\Doctrines\Models\SDE\InvGroup;
use Seat\Kassie\Doctrines\Models\SDE\DgmTypeEffect;
use Seat\Kassie\Doctrines\Models\SDE\DgmTypeAttribute;

use Seat\Kassie\Doctrines\Helpers\SDEHelper;

class InvType extends Model
{

	protected $table = 'invTypes';
	protected $primaryKey = 'typeID';

	public function fits()
	{
		return $this->belongsToMany(Fit::class, 'doctrines_fit_inv_type')->withPivot('state', 'qty');
	}

	public function inv_group()
	{
		return $this->belongsTo(InvGroup::class, 'groupID', 'groupID');
	}

	public function dgm_type_effects()
	{
		return $this->hasMany(DgmTypeEffect::class, 'typeID', 'typeID');
	}

	public function dgm_type_attributes()
	{
		return $this->hasMany(DgmTypeAttribute::class, 'typeID', 'typeID');
	}

	public function getSlotAttribute()
	{
		if ($this->inv_group->inv_category->categoryName == 'Module') {
			$effectID = $this->dgm_type_effects->whereIn('effectID', [11, 12, 13, 2663])->first()->effectID;
			return SDEHelper::effectIDToHuman($effectID);
		}
		else if ($this->inv_group->inv_category->categoryName == 'Subsystem') {
			return 'subsystem';
		}

		return null;
	}

}