<?php
namespace Cacing69\BITBuilder;

use Cacing69\BITBuilder\Adapters\QueryBuilderAdapter;
use Cacing69\BITBuilder\Exceptions\FactoryBuilderException;
use Cacing69\BITBuilder\Filterable;
use Cacing69\BITBuilder\Filterable\CallbackFilter;
use Cacing69\BITBuilder\Filterable\ExactFilter;
use Cacing69\BITBuilder\Filterable\LikeFilter;
use Cacing69\BITBuilder\Filterable\GreaterThanEqualFilter;
use Cacing69\BITBuilder\Filterable\GreaterThanFilter;
use Cacing69\BITBuilder\Filterable\LessThanEqualFilter;
use Cacing69\BITBuilder\Filterable\LessThanFilter;
use Cacing69\BITBuilder\Sortable\FieldSort;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FactoryBuilder {
	use QueryBuilderAdapter;

	protected $source;
	protected $request;
	protected $filters;
	protected $sorts;
	protected $maxPerPage = 100;
	protected $perPage = 20;
	protected $showAll = false;
	protected $paginationMode = "DESC";
	protected $nextCursor = "<";

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

	public function addSorts($sorts)
	{
		if($this->request->filled("sort_by")) {
			foreach ($sorts as $key => $value) {
				if($value instanceof FieldSort) {
					if(Str::contains($this->request->sort_by, "-")) {
						$this->paginationMode = "ASC";
						$this->nextCursor = ">";
					}

					$this->source = $this->source->orderBy($value->column, $this->paginationMode);
				}
			}
		}

		return $this;
	}

	public function removeLimit()
	{
		$this->showAll = true;
		return $this;
	}

	public function defaultSort($value)
	{

		if(Str::contains($value, "-")) {
			$this->paginationMode = "ASC";
			$this->nextCursor = ">";
		}

		$this->source = $this->source->orderBy($value, $this->paginationMode);

		return $this;
	}

	public function addFilters($filters)
	{
		if($this->request->filled("filter")) {
			foreach ($filters as $key => $value) {
				if(gettype($this->request->filter) == "array") {
					if(array_key_exists($value->key, $this->request->filter ?? [])){
						if($value instanceof ExactFilter) {
							$this->source = $this->source->where($value->column, $this->request->filter[$value->key]);
						} else if($value instanceof GreaterThanFilter) {
							$this->source = $this->source->where($value->column, ">" , $this->request->filter[$value->key]);
						} else if($value instanceof GreaterThanEqualFilter) {
							$this->source = $this->source->where($value->column, ">=" , $this->request->filter[$value->key]);
						} else if($value instanceof LessThanFilter) {
							$this->source = $this->source->where($value->column, "<" , $this->request->filter[$value->key]);
						} else if($value instanceof LessThanEqualFilter) {
							$this->source = $this->source->where($value->column, "<=" , $this->request->filter[$value->key]);
						} else if($value instanceof LikeFilter) {
							if($value->mode == Filterable::LIKE_BEGIN_END) {
								$this->source = $this->source->where($value->column, "LIKE" , "%".$this->request->filter[$value->key]."%");
							} else if($value->mode == Filterable::LIKE_BEGIN) {
								$this->source = $this->source->where($value->column, "LIKE" , $this->request->filter[$value->key]."%");
							} else if($value->mode == Filterable::LIKE_END) {
								$this->source = $this->source->where($value->column, "LIKE" , "%".$this->request->filter[$value->key]);
							}
						}
					}
				}
			}
		}

		return $this;
	}
}