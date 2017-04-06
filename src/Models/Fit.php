<?php

namespace Seat\Kassie\Doctrines\Models;

use Illuminate\Database\Eloquent\Model;

use Seat\Kassie\Doctrines\Helpers\ParserEFT;

class Fit extends Model
{
	protected $table = 'doctrines_fits';
	protected $fillable = [
		'name',
		'raw',
		'published',
		'comment'
	];

	public function setRawAttribute($value) {
		/* http://stackoverflow.com/a/709684 */
		$this->attributes['raw'] = trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $value));
	}

	public function getPrettyDisplayAttribute() {
		return ParserEFT::Parse($this->attributes['raw']);
	}

}
