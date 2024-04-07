<?php

namespace IPP\Student\Instruction\Control;

use IPP\Student\Instruction;
use IPP\Student\Argument\LabelArgument;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Argument\VariableArgument;

class JUMPIFEQInstruction extends Instruction
{
    private LabelArgument $label;
    private ConstantArgument|VariableArgument $source1;
    private ConstantArgument|VariableArgument $source2;

    public function __construct(int $order, LabelArgument $label, ConstantArgument|VariableArgument $source1, ConstantArgument|VariableArgument $source2)
    {
        parent::__construct($order);
        $this->label = $label;
        $this->source1 = $source1;
        $this->source2 = $source2;
    }

    public function execute(): void
    {
    }
}
