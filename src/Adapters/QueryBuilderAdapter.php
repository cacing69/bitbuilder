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
					throw new FactoryBuilderException("max value per_page is 100");
				}
			}

			$this->limit($this->perPage);
		}
		
		return $this->source->get();
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
		return $this->source->paginate($paginate);;
	}
}