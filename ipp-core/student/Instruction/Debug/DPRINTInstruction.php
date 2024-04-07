<?php

namespace IPP\Student\Instruction\Debug;

use IPP\Student\Instruction;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Argument\VariableArgument;

class DPRINTInstruction extends Instruction
{
    private ConstantArgument|VariableArgument $source;

    public function __construct(int $order, ConstantArgument|VariableArgument $source)
    {
        parent::__construct($order);
        $this->source = $source;
    }

    public function execute(): void
    {
    }
}
