<?php

namespace IPP\Student\Instruction\DataFrame;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;

class POPSInstruction extends Instruction
{
    private VariableArgument $destination;

    public function __construct(int $order, VariableArgument $destination)
    {
        parent::__construct($order);
        $this->destination = $destination;
    }

    public function execute(): void
    {
    }
}
