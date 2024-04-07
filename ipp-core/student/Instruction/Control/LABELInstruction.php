<?php

namespace IPP\Student\Instruction\Control;

use IPP\Student\Instruction;
use IPP\Student\Argument\LabelArgument;
use IPP\Student\Scheduler;

class LABELInstruction extends Instruction
{
    private LabelArgument $label;

    public function __construct(int $order, LabelArgument $label, Scheduler $scheduler)
    {
        $this->order = $order;
        $this->label = $label;
    }

    public function execute(): void
    {
        // Roses are red,
        // Violets are blue,
        // This is a LABEL,
        // And it does nothing too.
    }
}
