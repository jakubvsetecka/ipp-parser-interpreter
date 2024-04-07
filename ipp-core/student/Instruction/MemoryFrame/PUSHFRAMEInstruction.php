<?php

namespace IPP\Student\Instruction\MemoryFrame;

use IPP\Student\Instruction;
use IPP\Student\FrameModel;

class PUSHFRAMEInstruction extends Instruction
{
    private FrameModel $frameModel;

    public function __construct(int $order, FrameModel $frameModel)
    {
        $this->order = $order;
        $this->frameModel = $frameModel;
    }

    public function execute(): void
    {
        $this->frameModel->pushFrame();
    }
}
