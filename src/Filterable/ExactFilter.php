<?php
namespace Cacing69\BITBuilder\Filterable;

class ExactFilter {
	public $column;
	public $realColumn;

	public function __construct($column, $realColumn = null)
	{
		$this->column = $column;
		$this->realColumn = $realColumn ?? $column;
	}
}