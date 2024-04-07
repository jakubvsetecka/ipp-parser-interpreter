<?php

namespace IPP\Student\Argument;

use IPP\Student\Argument;
use IPP\Student\Argument\RegexPattern\RegexPattern;

class LabelArgument extends Argument
{
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
