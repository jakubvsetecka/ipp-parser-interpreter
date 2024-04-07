<?php

namespace IPP\Student\Instruction\Strings;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\FrameModel;

class CONCATInstruction extends Instruction
{
    private VariableArgument $destination;
    private ConstantArgument|VariableArgument $source1;
    private ConstantArgument|VariableArgument $source2;

    private FrameModel $frameModel;

    public function __construct(int $order, VariableArgument $destination, ConstantArgument|VariableArgument $source1, ConstantArgument|VariableArgument $source2, FrameModel $frameModel)
    {
        $this->order = $order;
        $this->destination = $destination;
        $this->source1 = $source1;
        $this->source2 = $source2;
        $this->frameModel = $frameModel;
    }

    public function execute(): void
    {
        $value1 = null;
        $value2 = null;

        if ($this->source1 instanceof ConstantArgument) {
            $value1 = $this->source1->getValue();
        } else {
            $frame = $this->source1->getFrame();
            $name = $this->source1->getValue();
            $variable = $this->frameModel->getVariable($frame, $name);
            $value1 = $variable->getValue();
        }

        if ($this->source2 instanceof ConstantArgument) {
            $value2 = $this->source2->getValue();
        } else {
            $frame = $this->source2->getFrame();
            $name = $this->source2->getValue();
            $variable = $this->frameModel->getVariable($frame, $name);
            $value2 = $variable->getValue();
        }

        $result = $value1 . $value2;

        $this->frameModel->setVariable($this->destination->getFrame(), $this->destination->getValue(), $result);
    }
}
