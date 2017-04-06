<?php

namespace Seat\Kassie\Doctrines\Models\SDE;

use Illuminate\Database\Eloquent\Model;

use Seat\Kassie\Doctrines\Models\SDE\InvType;

class DgmTypeEffect extends Model
{
	
	protected $table = 'dgmTypeEffects';

	public function inv_type()
	{
		return $this->belongsTo(InvType::class, 'typeID', 'typeID');
	}

}