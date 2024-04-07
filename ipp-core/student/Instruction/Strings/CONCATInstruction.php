<?php

namespace IPP\Student\Instruction\Strings;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;

class CONCATInstruction extends Instruction
{
    private VariableArgument $destination;
    private ConstantArgument|VariableArgument $source1;
    private ConstantArgument|VariableArgument $source2;

    public function __construct(int $order, VariableArgument $destination, ConstantArgument|VariableArgument $source1, ConstantArgument|VariableArgument $source2)
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
