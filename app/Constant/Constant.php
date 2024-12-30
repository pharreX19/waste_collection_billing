<?php

namespace App\Constant;

use ReflectionClass;

class Constant
{
    function all()
    {
        $class = new ReflectionClass($this);
        return $class->getConstants();
    }
}
