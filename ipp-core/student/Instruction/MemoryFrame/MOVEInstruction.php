<?php

namespace IPP\Student\Instruction\MemoryFrame;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\FrameModel;

class MOVEInstruction extends Instruction
{
    private VariableArgument $destination;
    private ConstantArgument|VariableArgument $source;

    private FrameModel $frameModel;

    public function __construct(int $order, VariableArgument $destination, ConstantArgument|VariableArgument $source, FrameModel $frameModel)
    {
        parent::__construct($order);
        $this->destination = $destination;
        $this->source = $source;
        $this->frameModel = $frameModel;
    }

    public function execute(): void
    {
        $value = null;

        if ($this->source instanceof ConstantArgument) {
            $value = $this->source->getValue();
        } else {
            $name = $this->source->getValue();
            $frame = $this->source->getFrame();
            $variable = $this->frameModel->getVariable($frame, $name);
            $value = $variable->getValue();
        }

        $this->frameModel->setVariable($this->destination->getFrame(), $this->destination->getValue(), $value);
    }
}
