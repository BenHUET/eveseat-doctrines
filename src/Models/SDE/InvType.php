<?php

namespace Seat\Kassie\Doctrines\Models\SDE;

use Illuminate\Database\Eloquent\Model;

use Seat\Kassie\Doctrines\Models\SDE\InvGroup;
use Seat\Kassie\Doctrines\Models\SDE\DgmTypeEffect;
use Seat\Kassie\Doctrines\Models\SDE\DgmTypeAttribute;

class InvType extends Model
{

	protected $table = 'invTypes';

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

}