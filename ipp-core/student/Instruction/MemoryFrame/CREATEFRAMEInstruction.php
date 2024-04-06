<?php

namespace IPP\Student\Instruction\MemoryFrame;

use IPP\Student\Instruction;

class CREATEFRAMEInstruction extends Instruction
{
    public function execute(): void
    {
        global $FRAME_MODEL;
        $FRAME_MODEL->createFrame();
    }
}
