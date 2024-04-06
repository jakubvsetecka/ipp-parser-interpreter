<?php

namespace IPP\Student\Instruction\Arithmetics;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\SymbolArgument;

class ORInstruction extends Instruction
{
    private VariableArgument $destination;
    private SymbolArgument $source1;
    private SymbolArgument $source2;

    public function __construct(int $order, VariableArgument $destination, SymbolArgument $source1, SymbolArgument $source2)
    {
        parent::__construct($order);
        $this->destination = $destination;
        $this->source1 = $source1;
        $this->source2 = $source2;
    }

    public function execute(): void
    {
    }
}
