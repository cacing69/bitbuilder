<?php
namespace Cacing69\BITBuilder;

use Cacing69\BITBuilder\Filterable\CallbackFilter;
use Cacing69\BITBuilder\Filterable\ExactFilter;
use Cacing69\BITBuilder\Filterable\GreaterThanEqualFilter;
use Cacing69\BITBuilder\Filterable\GreaterThanFilter;

class Filterable {
	public static function exact($p1, $p2 = null)
	{
		return new ExactFilter($p1, $p2);
	}

	public static function callback($p1, $p2)
	{
		return new CallbackFilter($p1, $p2);
	}

	public static function greaterThan($p1, $p2)
	{
		return new GreaterThanFilter($p1, $p2);
	}

	public static function greaterThanEqual($p1, $p2)
	{
		return new GreaterThanEqualFilter($p1, $p2);
	}

	public static function lessThan($p1, $p2)
	{
		return new LessThanFilter($p1, $p2);
	}

	public static function lessThanEqual($p1, $p2)
	{
		return new LessThanEqualFilter($p1, $p2);
	}
}