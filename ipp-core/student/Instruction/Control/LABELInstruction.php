<?php

namespace IPP\Student\Instruction\Control;

use IPP\Student\Instruction;
use IPP\Student\Argument\LabelArgument;

class LABELInstruction extends Instruction
{
    private LabelArgument $label;

    public function __construct(int $order, LabelArgument $label)
    {
        parent::__construct($order);
        $this->label = $label;
    }

    public function execute(): void
    {
    }
}
