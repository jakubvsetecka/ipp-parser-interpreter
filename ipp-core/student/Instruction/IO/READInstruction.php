<?php

namespace IPP\Student\Instruction\IO;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\TypeArgument;

class READInstruction extends Instruction
{
    private VariableArgument $destination;
    private TypeArgument $type;

    public function __construct(int $order, VariableArgument $destination, TypeArgument $type)
    {
        parent::__construct($order);
        $this->destination = $destination;
        $this->type = $type;
    }

    public function execute(): void
    {
    }
}
