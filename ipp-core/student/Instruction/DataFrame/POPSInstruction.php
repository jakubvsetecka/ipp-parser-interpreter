<?php

namespace IPP\Student\Instruction\DataFrame;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\DataStack;
use IPP\Student\FrameModel;

class POPSInstruction extends Instruction
{
    private VariableArgument $destination;

    private DataStack $dataStack;
    private FrameModel $frameModel;

    public function __construct(int $order, VariableArgument $destination, DataStack $dataStack, FrameModel $frameModel)
    {
        $this->order = $order;
        $this->destination = $destination;
        $this->dataStack = $dataStack;
        $this->frameModel = $frameModel;
    }

    public function execute(): void
    {
        $value = $this->dataStack->pop();

        $name = $this->destination->getValue();
        $frame = $this->destination->getFrame();
        $variable = $this->frameModel->getVariable($frame, $name);
        $variable->setValue($value);
    }
}
