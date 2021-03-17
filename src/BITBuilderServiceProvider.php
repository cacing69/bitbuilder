<?php 
namespace Cacing69\BITBuilder;

use Cacing69\BITBuilder\FactoryBuilder;
use Illuminate\Support\ServiceProvider;

class BITBuilderServiceProvider extends ServiceProvider
{
	public function register()
    {
    	$this->app->bind('bitbuilder', function(){
            return new FactoryBuilder();
        });

        $this->app->alias('bitbuilder', FactoryBuilder::class);
    }
}