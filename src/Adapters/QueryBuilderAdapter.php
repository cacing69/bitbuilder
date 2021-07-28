<?php
namespace Cacing69\BITBuilder\Adapters;

trait QueryBuilderAdapter {
	public function limit($value)
	{
		$this->source = $this->source->limit($value);
		return $this;
	}

	public function get()
	{
		if(!$this->showAll) {
			if($this->request->filled("per_page")) {
				$this->perPage = $this->request->per_page;
			}

			if($this->perPage < 0) {
				throw new FactoryBuilderException("min value per_page is 1");
			} else {
				if($this->perPage > $this->maxPerPage) {
					throw new FactoryBuilderException("max value per_page is ".$this->maxPerPage);
				} else {
					if($this->perPage != 0) {
						if(!$this->showAll) {
							$this->limit($this->perPage);
						}
					}
				}
			}
		}

		if($this->request->filled("last_id") && !empty($this->cursor)) {
			$this->moveCursor("media_id", $this->request->last_id);
		}

		return $this->source->get();
	}

	public function toSql()
	{
		return $this->source->toSql();
	}

	public function getBindings()
	{
		return $this->source->getBindings();
	}

	public function with(...$params)
	{
		if($this->source instanceof EloquentBuilder) {
			$this->source = $this->source->with(...$params);
		}

		return $this;
	}

	public function where(...$params)
	{
		$this->source = $this->source->where(...$params);
		return $this;
	}

	public function paginate($paginate)
	{
		return $this->source->paginate($paginate);
	}

	public function moveCursor($column, $last_id)
	{
		$this->source->where($column, $this->nextCursor, $last_id);

		return $this;
	}
}
