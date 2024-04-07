<?php

namespace IPP\Student\Argument;

use IPP\Student\Argument;

class ConstantArgument extends Argument
{
    private Int|Bool|String|null $constant;

    public function __construct($constant)
    {
        $this->constant = $constant;
        $this->value = $constant;
    }

    public function __toString()
    {
        return $this->constant;
    }

    public function getValue()
    {
        return $this->constant;
    }
}
