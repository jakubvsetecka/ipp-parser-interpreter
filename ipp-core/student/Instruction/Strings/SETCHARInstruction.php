<?php

namespace IPP\Student\Instruction\Strings;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;

class SETCHARInstruction extends Instruction
{
    private VariableArgument $destination;
    private ConstantArgument|VariableArgument $index;
    private ConstantArgument|VariableArgument $symbol;

    public function __construct(int $order, VariableArgument $destination, ConstantArgument|VariableArgument $index, ConstantArgument|VariableArgument $symbol)
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
