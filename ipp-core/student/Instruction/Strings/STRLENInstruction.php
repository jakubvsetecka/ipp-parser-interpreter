<?php

namespace IPP\Student\Instruction\Strings;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;

class STRLENInstruction extends Instruction
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
