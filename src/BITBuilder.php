<?php

namespace Cacing69\BITBuilder;
use Cacing69\BITBuilder\BITBuilderFacade;
use Illuminate\Support\Facades\Facade;

class BITBuilder
 extends Facade {
    protected static function getFacadeAccessor(){
        return 'bitbuilder';
    }
}