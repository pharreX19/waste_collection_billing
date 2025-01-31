<?php

namespace App\Constants;

use ReflectionClass;

class Constant
{
    function all()
    {
        $class = new ReflectionClass($this);
        return $class->getConstants();
    }
}
