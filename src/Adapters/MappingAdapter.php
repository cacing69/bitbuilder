<?php
namespace Cacing69\BITBuilder\Adapters;

class MappingAdapter {
	public $key;
	public $column;

	public function __construct($key, $column)
	{
		$this->key = $key;
		$this->column = $column;
	}
}