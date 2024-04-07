<?php

namespace IPP\Student\Instruction\Types;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;

class TYPEInstruction extends Instruction
{
    private VariableArgument $destination;
    private ConstantArgument|VariableArgument $source;

    public function __construct(int $order, VariableArgument $destination, ConstantArgument|VariableArgument $source)
    {
        parent::__construct($order);
        $this->destination = $destination;
        $this->source = $source;
    }

    public function execute(): void
    {
    }
}
