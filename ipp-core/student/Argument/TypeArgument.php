<?php

namespace IPP\Student\Argument;

use IPP\Student\Argument;

class TypeArgument extends Argument
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
