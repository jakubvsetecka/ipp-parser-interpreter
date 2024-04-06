<?php

namespace IPP\Student\Instruction\Control;

use IPP\Student\Instruction;
use IPP\Student\Argument\SymbolArgument;

class EXITInstruction extends Instruction
{
    private SymbolArgument $return_code;

    public function __construct(int $order, SymbolArgument $return_code)
    {
        parent::__construct($order);
        $this->return_code = $return_code;
    }

    public function execute(): void
    {
    }
}
