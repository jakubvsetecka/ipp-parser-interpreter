<?php

namespace IPP\Student\Instruction\Arithmetics;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\FrameModel;

class STR2INTInstruction extends Instruction
{
    private VariableArgument $destination;
    private ConstantArgument|VariableArgument $source;
    private ConstantArgument|VariableArgument $index;

    private FrameModel $frameModel;

    public function __construct(int $order, VariableArgument $destination, ConstantArgument|VariableArgument $source, ConstantArgument|VariableArgument $index, FrameModel $frameModel)
    {
        $this->order = $order;
        $this->destination = $destination;
        $this->source = $source;
        $this->index = $index;
        $this->frameModel = $frameModel;
    }

    public function execute(): void
    {
        $value = null;
        $index = null;

        if ($this->source instanceof ConstantArgument) {
            $value = $this->source->getValue();
        } else {
            $name = $this->source->getValue();
            $frame = $this->source->getFrame();
            $variable = $this->frameModel->getVariable($frame, $name);
            $value = $variable->getValue();
        }

        if ($this->index instanceof ConstantArgument) {
            $index = $this->index->getValue();
        } else {
            $name = $this->index->getValue();
            $frame = $this->index->getFrame();
            $variable = $this->frameModel->getVariable($frame, $name);
            $index = $variable->getValue();
        }

        $result = ord($value[$index]);

        $name = $this->destination->getValue();
        $frame = $this->destination->getFrame();
        $variable = $this->frameModel->getVariable($frame, $name);
        $variable->setValue($result);
    }
}
