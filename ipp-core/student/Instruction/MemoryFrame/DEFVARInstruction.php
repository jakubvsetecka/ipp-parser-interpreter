<?php

namespace IPP\Student\Instruction\MemoryFrame;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\FrameModel;

class DEFVARInstruction extends Instruction
{
    private VariableArgument $variable;
    private FrameModel $frameModel;

    public function __construct(int $order, VariableArgument $variable, FrameModel $frameModel)
    {
        parent::__construct($order);
        $this->variable = $variable;
        $this->frameModel = $frameModel;
    }

    public function execute(): void
    {
        $frame = $this->variable->getFrame();
        $name = $this->variable->getValue();

        $this->frameModel->addVariable($frame, (string)$name, null, false);
    }
}
