<?php

namespace Seat\Kassie\Doctrines\Models\SDE;

use Illuminate\Database\Eloquent\Model;

use Seat\Kassie\Doctrines\Models\SDE\InvType;
use Seat\Kassie\Doctrines\Models\SDE\InvCategory;


class InvGroup extends Model
{

	protected $table = 'invGroups';

	public function inv_types()
	{
		return $this->hasMany(InvType::class, 'groupID', 'groupID');
	}

	public function inv_category()
	{
		return $this->belongsTo(InvCategory::class, 'categoryID', 'categoryID');
	}

}