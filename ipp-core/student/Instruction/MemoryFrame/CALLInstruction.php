<?php

namespace IPP\Student\Instruction\MemoryFrame;

use IPP\Student\Instruction;
use IPP\Student\Argument\LabelArgument;
use IPP\Student\Scheduler;

class CALLInstruction extends Instruction
{
    private LabelArgument $label;

    private Scheduler $scheduler;

    public function __construct(int $order, LabelArgument $label, Scheduler $scheduler)
    {
        $this->order = $order;
        $this->label = $label;
    }

    public function execute(): void
    {
        $this->scheduler->call($this->label->getValue());
    }
}
