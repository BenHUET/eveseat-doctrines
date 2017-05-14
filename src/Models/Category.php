<?php

namespace Seat\Kassie\Doctrines\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	public $timestamps = false;
	
	protected $table = 'doctrines_fit_category';
	protected $fillable = [
		'name'
	];


}
