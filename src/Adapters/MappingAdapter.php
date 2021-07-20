<?php
namespace Cacing69\BITBuilder\Adapters;

class MappingAdapter {
	public $key;
	public $column;
	public $mode;

	public function __construct($key, $column, $mode = null)
	{
		$this->key = $key;
		$this->column = $column;
		$this->mode = $mode;
	}
}