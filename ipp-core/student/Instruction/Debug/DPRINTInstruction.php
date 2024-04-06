<?php

namespace IPP\Student\Instruction\Debug;

use IPP\Student\Instruction;
use IPP\Student\Argument\SymbolArgument;

class DPRINTInstruction extends Instruction
{
    private SymbolArgument $source;

    public function __construct(int $order, SymbolArgument $source)
    {
        parent::__construct($order);
        $this->source = $source;
    }

    public function execute(): void
    {
    }
}
