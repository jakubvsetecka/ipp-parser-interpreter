<?php

namespace IPP\Student\Argument;

use IPP\Student\Argument;

class TypeArgument extends Argument
{
    public function __construct($value)
    {
        $regex_pattern = '/^(int|string|bool)$/';
        parent::__construct($value, $regex_pattern);
    }
}
