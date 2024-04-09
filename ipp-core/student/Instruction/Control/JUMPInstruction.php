<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student\Instruction\Control;

use IPP\Student\Instruction;
use IPP\Student\Argument\LabelArgument;
use IPP\Student\Scheduler;

/**
 * JUMP instruction class.
 */
class JUMPInstruction extends Instruction
{
    private LabelArgument $label;

    private Scheduler $scheduler;

    public function __construct(int $order, LabelArgument $label, Scheduler $scheduler)
    {
        $this->order = $order;
        $this->label = $label;
        $this->scheduler = $scheduler;
    }

    public function execute(): void
    {
        $this->scheduler->jump((string)$this->label->getValue());
    }
}
