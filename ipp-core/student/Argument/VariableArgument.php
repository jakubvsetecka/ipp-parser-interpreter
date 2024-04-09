<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student\Argument;

use IPP\Student\Argument;

/**
 * Argument representing a variable.
 */
class VariableArgument extends Argument
{
    private string $frame;

    public function __construct(string $value)
    {
        $this->frame = substr($value, 0, 2);
        $this->value = substr($value, 3);
    }

    public function __toString(): string
    {
        return (string) $this->getValue();
    }

    public function getFrame(): string
    {
        return $this->frame;
    }
}
