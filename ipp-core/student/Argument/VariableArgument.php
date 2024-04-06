<?php

namespace IPP\Student\Argument;

use IPP\Student\Argument;

class VariableArgument extends Argument
{
    private $frame;

    public function __construct($value)
    {
        $regex_pattern = '/^(LF|TF|GF)@([a-zA-Z_\-$&%*!?][a-zA-Z0-9_\-$&%*!?]*)$/';
        parent::__construct($value, $regex_pattern);
        $this->frame = substr($value, 0, 2);
    }

    public function getFrame()
    {
        return $this->frame;
    }

    // Inherits getValue() from Argument
}
