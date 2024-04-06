<?php

namespace IPP\Student\Argument;

use IPP\Student\Argument;

class SymbolArgument extends Argument
{
    private bool $is_constant;
    private $type = null;
    private $frame = null;

    public function __construct($value)
    {
        $regex_pattern = '/^(var|bool|int|string)@(.+)$/';
        parent::__construct($value, $regex_pattern);
        if ($this->isConstant()) {
            $this->is_constant = true;
        } else {
            $this->is_constant = false;
        }
    }

    private function isConstant(): bool
    {
        return preg_match('/^(int|string|bool|nil)@(.+)$/', $this->value);
    }
}
