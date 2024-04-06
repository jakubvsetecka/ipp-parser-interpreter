<?php

namespace IPP\Student\Argument;

use IPP\Student\Argument;
use IPP\Student\Argument\RegexPattern\RegexPattern;

class TypeArgument extends Argument
{
    public function __construct($value)
    {
        if (RegexPattern::Type->match($value) === false) {
            throw new \InvalidArgumentException("Invalid type argument");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
