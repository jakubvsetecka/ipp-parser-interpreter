<?php

namespace IPP\Student\Instruction\Debug;

use IPP\Core\Interface\OutputWriter;
use IPP\Student\FrameModel;
use IPP\Student\Instruction;
use IPP\Student\Scheduler;

class BREAKInstruction extends Instruction
{
    private Scheduler $scheduler;
    private OutputWriter $stderr;
    private FrameModel $frameModel;

    public function __construct(int $order, Scheduler $scheduler, OutputWriter $stderr, FrameModel $frameModel)
    {
        $this->order = $order;
        $this->scheduler = $scheduler;
        $this->stderr = $stderr;
        $this->frameModel = $frameModel;
    }

    public function execute(): void
    {
        $instructions = $this->scheduler->getInstructions();

        $this->stderr->writeString("\n");
        $this->stderr->writeString("----------Instruction list----------\n");

        foreach ($instructions as $instruction) {
            if ($instruction->getOrder() === $this->getOrder()) {
                $this->stderr->writeString('--> ');
            }
            $instruction->print($this->stderr);
        }

        $this->stderr->writeString("----------End of instruction list----------\n");

        $this->stderr->writeString("\n");

        $this->stderr->writeString($this->frameModel);
    }
}
