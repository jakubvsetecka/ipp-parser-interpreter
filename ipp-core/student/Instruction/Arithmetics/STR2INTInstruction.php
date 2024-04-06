<?php

namespace IPP\Student\Instruction\Arithmetics;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\SymbolArgument;

class STR2INTInstruction extends Instruction
{
    private VariableArgument $destination;
    private SymbolArgument $source;
    private SymbolArgument $index;

    public function __construct(int $order, VariableArgument $destination, SymbolArgument $source, SymbolArgument $index)
    {
        parent::__construct($order);
        $this->destination = $destination;
        $this->source = $source;
        $this->index = $index;
    }

    public function execute(): void
    {
    }
}
