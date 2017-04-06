<?php

namespace Seat\Kassie\Doctrines\Models\SDE;

use Illuminate\Database\Eloquent\Model;

use Seat\Kassie\Doctrines\Models\SDE\InvGroup;

class InvCategory extends Model
{
	
	protected $table = 'invCategories';

	public function inv_groups()
	{
		return $this->hasMany(InvGroup::class, 'categoryID', 'categoryID');
	}

}