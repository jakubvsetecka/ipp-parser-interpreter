<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student\Instruction\MemoryFrame;

use IPP\Student\Instruction;
use IPP\Student\Scheduler;

/**
 * RETURN instruction class.
 */
class RETURNInstruction extends Instruction
{
    private Scheduler $scheduler;

    public function __construct(int $order, Scheduler $scheduler)
    {
        $this->order = $order;
        $this->scheduler = $scheduler;
    }

    public function execute(): void
    {
        $this->scheduler->ret();
    }
}
