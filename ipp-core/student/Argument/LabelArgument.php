<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student\Argument;

use IPP\Student\Argument;

/**
 * Argument representing a label.
 */
class LabelArgument extends Argument
{
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return (string) $this->getValue();
    }
}
