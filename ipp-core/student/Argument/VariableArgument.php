<?php

namespace IPP\Student\Argument;

use IPP\Student\Argument;
use IPP\Student\Argument\RegexPattern\RegexPattern;

class VariableArgument extends Argument
{
    private $frame;

    public function __construct($value)
    {
        if (RegexPattern::Variable->match($value) === false)
            throw new \InvalidArgumentException(sprintf('Invalid variable name: %s', $value));

        $this->frame = RegexPattern::BeforeAt->getValue($value);
        $this->value = RegexPattern::AfterAt->getValue($value);
    }

    public function getFrame()
    {
        return $this->frame;
    }

    public function __toString()
    {
        return $this->getValue(); // Assuming getValue() returns a string representation of the value
    }
}
