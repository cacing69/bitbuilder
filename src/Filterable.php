<?php
namespace Cacing69\BITBuilder;

use Cacing69\BITBuilder\Filterable\CallbackFilter;
use Cacing69\BITBuilder\Filterable\ExactFilter;

class Filterable {
	public static function exact($p1, $p2 = null)
	{
		return new ExactFilter($p1, $p2);
	}

	public static function callback($p1, $p2)
	{
		return new CallbackFilter($p1, $p2);
	}
}