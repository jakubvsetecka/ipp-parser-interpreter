<?php

namespace IPP\Student\Argument;

use IPP\Student\Argument;

class LabelArgument extends Argument
{
    public function __construct($value)
    {
        $regex_pattern = '/^([a-zA-Z]|_|-|\$|&|%|\*|!|\?)([a-zA-Z0-9]|_|-|\$|&|%|\*|!|\?)*$/';
        parent::__construct($value, $regex_pattern);
    }
}
