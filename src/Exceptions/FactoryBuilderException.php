<?php
namespace Cacing69\BITBuilder\Exceptions;

use Exception;

class FactoryBuilderException extends Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
