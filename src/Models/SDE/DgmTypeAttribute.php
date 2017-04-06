<?php

namespace Seat\Kassie\Doctrines\Models\SDE;

use Illuminate\Database\Eloquent\Model;

use Seat\Kassie\Doctrines\Models\SDE\InvType;

class DgmTypeAttribute extends Model
{
	
	protected $table = 'dgmTypeAttributes';

	public function inv_type()
	{
		return $this->belongsTo(InvType::class, 'typeID', 'typeID');
	}

	public function getValueAttribute()
	{
		return (int) ($this->valueInt . $this->valueFloat);
	}

}