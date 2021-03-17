# BITBuilder

### Make easy query builder / eloquent queries with requests for API Response on Laravel / Lumen

This package has feature to filter, sort and include relations based on request. BITBuilder can be applied on Laravel's default Eloquent builder & Query Builder. Query parameter names follow the [JSON API specification](https://jsonapi.org/).

## Quick Installation
```
composer require cacin69/bitbuilder
```

## How to use with eloquent
```php
use App\Models\User;
use Cacing69\BITBuilder\FactoryBuilder;
use Cacing69\BITBuilder\Filterable;
use Cacing69\BITBuilder\Sortable;
...
public function index(Request $request)
{
	$factory = new FactoryBuilder();

	$data = $factory->on(User::class)
			->addFilters([
				Filterable::exact("id", "user_id"), // fill second parameter, if u want to make alias on request
				Filterable::callback("status", function($query, $value) {
					$query->where('user_status', $value); // u can do everything with this value
				})
			])
			->addSorts([
				Sortable::field('id', 'user_id') // will allow to sort via request url?sort_by=id (DESC), url?sort_by=-id (ASC)
			])
			->defaultSort("user_id") // will sort user by user_id DESC, u can use -user_id to make sort by ASC
			->limit(20) // add limitation u can call force to show all data with method $obj->showAllData(true);
			->with("media") // call eloquent relation
			->where("user_blocked", 1) // add wehre clause on User
			->get(); // u can paginate also there -> paginate(20);
}

```

## How to use with query builder
```php
use DB;
use Cacing69\BITBuilder\FactoryBuilder;
use Cacing69\BITBuilder\Filterable;
use Cacing69\BITBuilder\Sortable;
...
public function index(Request $request)
{
	$factory = new FactoryBuilder();

	$data = $factory->on(DB::table("t_user"))
			->addFilters([
				Filterable::exact("id", "user_id"), // fill second parameter, if u want to make alias on request
				Filterable::callback("status", function($query, $value) { // it will be filter data url?filter[status]=block
					$query->where('user_status', $value); // u can create any where clause with this value
				})
			])
			->addSorts([
				Sortable::field('id', 'user_id') // will allow to sort via request url?sort_by=id (DESC), url?sort_by=-id (ASC)
			])
			->defaultSort("user_id") // will sort user by user_id DESC, u can use -user_id to make sort by ASC
			->limit(20) // add limitation u can call force to show all data with method $obj->showAllData(true);
			->where("user_blocked", 1) // add wehre clause on User
			->get(); // u can paginate also there -> paginate(20);
}

```

## How to use logic on callback
```php

Filterable::callback("status", function($query, $value) {
	if($value == 1) {
		$query->where('column', "custom_value"); 
	}
})
```

## want to add more feature
You can help me fix the structure in this package, because I made this in a very short time for necessary purposes, any PR very welcome here, thank you

## License
The MIT License (MIT). Please see License File for more information.