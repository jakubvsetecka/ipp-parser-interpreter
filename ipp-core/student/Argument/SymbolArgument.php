<?php

namespace IPP\Student\Argument;

use IPP\Student\Argument;
use IPP\Student\Argument\RegexPattern\RegexPattern;

class SymbolArgument extends Argument
{
    private bool $is_constant;
    private $type = null;
    private $frame = null;

    public function __construct($value)
    {
        if (RegexPattern::Symbol->match($value) === false) {
            echo $value;
            throw new \InvalidArgumentException("Invalid symbol argument");
        }

        if (RegexPattern::Variable->match($value)) {
            $this->is_constant = false;
            $this->frame = RegexPattern::BeforeAt->getValue($value);
        } else {
            $this->is_constant = true;
            $this->type = RegexPattern::BeforeAt->getValue($value);
        }

        $this->value = RegexPattern::AfterAt->getValue($value);
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
