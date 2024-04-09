<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student\Instruction\MemoryFrame;

use IPP\Student\Instruction;
use IPP\Student\FrameModel;

/**
 * POPFRAME instruction class.
 */
class POPFRAMEInstruction extends Instruction
{
    private FrameModel $frameModel;

    public function __construct(int $order, FrameModel $frameModel)
    {
        $this->order = $order;
        $this->frameModel = $frameModel;
    }

    public function execute(): void
    {
        $this->frameModel->popFrame();
    }
}
