<?php

namespace IPP\Student\Instruction\DataFrame;

use IPP\Student\Instruction;
use IPP\Student\Argument\SymbolArgument;

class PUSHSInstruction extends Instruction
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
