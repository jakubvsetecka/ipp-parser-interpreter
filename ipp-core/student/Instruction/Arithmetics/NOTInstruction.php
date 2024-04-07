<?php

namespace IPP\Student\Instruction\Arithmetics;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\FrameModel;

class NOTInstruction extends Instruction
{
    private VariableArgument $destination;
    private ConstantArgument|VariableArgument $source;

    private FrameModel $frameModel;

    public function __construct(int $order, VariableArgument $destination, ConstantArgument|VariableArgument $source, FrameModel $frameModel)
    {
        $this->order = $order;
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

        $result = ~$value;

        $name = $this->destination->getValue();
        $frame = $this->destination->getFrame();
        $variable = $this->frameModel->getVariable($frame, $name);
        $variable->setValue($result);
    }
}
