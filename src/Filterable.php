<?php
namespace Cacing69\BITBuilder;

use Cacing69\BITBuilder\Filterable\CallbackFilter;
use Cacing69\BITBuilder\Filterable\ExactFilter;
use Cacing69\BITBuilder\Filterable\LikeFilter;
use Cacing69\BITBuilder\Filterable\GreaterThanEqualFilter;
use Cacing69\BITBuilder\Filterable\GreaterThanFilter;


class Filterable {
	const LIKE_BEGIN = 1;
	const LIKE_END = 2;
	const LIKE_BEGIN_END = 3;
	
	public static function exact($p1, $p2 = null)
	{
		return new ExactFilter($p1, $p2);
	}

	public static function like($p1, $p2, $p3 = Filterable::LIKE_BEGIN_END)
	{
		return new LikeFilter($p1, $p2, $p3);
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