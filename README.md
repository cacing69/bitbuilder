# BITBuilder

### Make easy query builder / eloquent queries with requests for API Response on Laravel / Lumen

This package has feature to filter, sort and include relations based on request. BITBuilder can be applied on Laravel's default Eloquent builder & Query Builder. Query parameter names follow the [JSON API specification](https://jsonapi.org/).

## Quick Installation
```
composer require cacing69/bitbuilder
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
				// do filter on db based on request ex : url?filter[id]=1 will generate query where user_id = 1
				Filterable::exact("id", "user_id"), // fill second parameter, if u want to make alias on request

				// do filter on db based on request ex : url?filter[foo]=lorem
				Filterable::like("foo", "column_foo", Filterable::LIKE_BEGIN) // generate query where column_foo like "lorem%"
				// OR Filterable::like("fist_name", "user_first_name", Filterable::LIKE_END) // generate query where column_foo like "%lorem"
				// OR Filterable::like("fist_name", "user_first_name", Filterable::LIKE_BEGIN_END) // generate query where column_foo like "%lorem%"
			])
			->addSorts([
				Sortable::field('id', 'user_id') // will allow to sort via request url?sort_by=id (DESC), url?sort_by=-id (ASC)
			])
			->defaultSort("user_id") // will sort user by user_id DESC, u can use -user_id to make sort by ASC
			->limit(20) // add limitation u can call force to show all data with method $obj->showAllData(true);
			->with("media") // call eloquent relation
			->where("user_blocked", 1) // add wehre clause on User
			->setCursor("last_id"); // optional if u want to cursor pagination
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
			... // same as before
}

```

## want to add more feature
You can help me fix the structure in this package, because I made this in a very short time for necessary purposes, any PR very welcome here, thank you

## License
The MIT License (MIT). Please see License File for more information.
