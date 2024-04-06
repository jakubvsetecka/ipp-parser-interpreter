<?php

namespace IPP\Student\Instruction\MemoryFrame;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;

class DEFVARInstruction extends Instruction
{
    private VariableArgument $variable;

    public function __construct(int $order, VariableArgument $variable)
    {
        parent::__construct($order);
        $this->variable = $variable;
    }

    public function execute(): void
    {
    }
}
