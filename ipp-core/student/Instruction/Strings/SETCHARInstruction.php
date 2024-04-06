<?php

namespace IPP\Student\Instruction\Strings;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\SymbolArgument;

class SETCHARInstruction extends Instruction
{
    private VariableArgument $destination;
    private SymbolArgument $index;
    private SymbolArgument $symbol;

    public function __construct(int $order, VariableArgument $destination, SymbolArgument $index, SymbolArgument $symbol)
    {
        parent::__construct($order);
        $this->destination = $destination;
        $this->index = $index;
        $this->symbol = $symbol;
    }

    public function execute(): void
    {
    }
}
