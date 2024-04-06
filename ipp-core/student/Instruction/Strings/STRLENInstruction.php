<?php

namespace IPP\Student\Instruction\Strings;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\SymbolArgument;

class STRLENInstruction extends Instruction
{
    private VariableArgument $destination;
    private SymbolArgument $source;

    public function __construct(int $order, VariableArgument $destination, SymbolArgument $source)
    {
        parent::__construct($order);
        $this->destination = $destination;
        $this->source = $source;
    }

    public function execute(): void
    {
    }
}
