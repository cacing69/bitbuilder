<?php
namespace Cacing69\BITBuilder\Filterable;

class CallbackFilter {
	public $column;
	public $callback;

	public function __construct($column, $callback)
	{
		$this->column = $column;
		$this->callback = $callback;
	}
}