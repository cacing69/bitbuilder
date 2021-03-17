<?php
namespace Cacing69\BITBuilder\Sortable;
class FieldSort {
	public $key;
	public $column;

	public function __construct($key, $column = null)
	{
		$this->key = $key;
		$this->column = $column ?? $key;
	}
}