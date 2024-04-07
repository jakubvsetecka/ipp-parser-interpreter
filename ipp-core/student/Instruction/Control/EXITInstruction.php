<?php

namespace IPP\Student\Instruction\Control;

use IPP\Student\Instruction;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Argument\VariableArgument;

class EXITInstruction extends Instruction
{
    private ConstantArgument|VariableArgument $return_code;

    public function __construct(int $order, ConstantArgument|VariableArgument $return_code)
    {
        parent::__construct($order);
        $this->return_code = $return_code;
    }

    public function execute(): void
    {
    }
}
