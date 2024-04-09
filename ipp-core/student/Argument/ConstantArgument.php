<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student\Argument;

use IPP\Student\Argument;

/**
 * Argument representing a constant.
 */
class ConstantArgument extends Argument
{
    private Int|Bool|String|null $constant;

    public function __construct(Int|Bool|String|null $constant)
    {
        $this->constant = $constant;
        $this->value = $constant;
    }

    public function __toString(): string
    {
        return (string) $this->constant;
    }

    public function getValue(): Int|Bool|String|null
    {
        return $this->constant;
    }
}
