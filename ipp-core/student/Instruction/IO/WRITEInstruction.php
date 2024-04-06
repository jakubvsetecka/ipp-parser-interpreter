<?php

namespace IPP\Student\Instruction\IO;

use IPP\Student\Instruction;
use IPP\Student\Argument\SymbolArgument;

class WRITEInstruction extends Instruction
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
