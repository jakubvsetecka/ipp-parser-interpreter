<?php

namespace IPP\Student\Instruction\Strings;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;

class GETCHARInstruction extends Instruction
{
    private VariableArgument $destination;
    private ConstantArgument|VariableArgument $source;
    private ConstantArgument|VariableArgument $index;

    public function __construct(int $order, VariableArgument $destination, ConstantArgument|VariableArgument $source, ConstantArgument|VariableArgument $index)
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
