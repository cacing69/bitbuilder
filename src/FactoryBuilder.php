<?php
namespace Cacing69\BITBuilder;

use Cacing69\BITBuilder\CallbackFilter;
use Cacing69\BITBuilder\ExactFilter;
use Cacing69\BITBuilder\FieldSort;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FactoryBuilder {
	protected $source;
	protected $request;

	public function on($source, ?Request $request = null)
	{
		if($source instanceof QueryBuilder) {
			$this->source = $source;
		} else {
			$this->source = app($source);
		}

		$this->request = $request ?? app(Request::class);
		return $this;
	}

	public function limit($value)
	{
		$this->source = $this->source->limit($value);
		return $this;
	}

	public function get()
	{
		return $this->source->get();
	}

	public function addSorts($sorts)
	{
		foreach ($sorts as $key => $value) {
			if($value instanceof FieldSort) {
				$mode = "DESC";

				if(Str::contains($this->request->order_by, "-")) {
					$mode = "ASC";
				}

				$this->source = $this->source->orderBy($value->realColumn, $mode);
			}
		}

		return $this;
	}

	public function addFilters($filters)
	{
		foreach ($filters as $key => $value) {
			if($value instanceof ExactFilter) {
				$this->source = $this->source->where($value->realColumn, $this->request->filter[$value->column]);
			}

			if($value instanceof CallbackFilter) {
				$callback = $value->callback;
 				$this->source = $this->source->where($callback($this->source, $this->request->filter[$value->column]));
			}
		}
		return $this;
	}

	public function where(...$params)
	{
		$this->source = $this->source->where($params[0], $params[1], $params[2]);
		return $this;
	}
}