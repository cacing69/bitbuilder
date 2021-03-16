<?php
namespace Cacing69\BITBuilder;

use Cacing69\BITBuilder\Sortable\FieldSort;

class Sortable {
	public static function field($p1, $p2 = null)
	{
		return new FieldSort($p1, $p2);
	}
}