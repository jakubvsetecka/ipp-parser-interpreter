<?php

namespace IPP\Student\Instruction\MemoryFrame;

use IPP\Student\FrameModel;
use IPP\Student\Instruction;

class CREATEFRAMEInstruction extends Instruction
{
    private FrameModel $frameModel;

    public function __construct(int $order, FrameModel $frameModel)
    {
        parent::__construct($order);
        $this->frameModel = $frameModel;
    }

    public function execute(): void
    {
        $this->frameModel->createFrame();
    }
}
