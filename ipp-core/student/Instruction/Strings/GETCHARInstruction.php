<?php

namespace IPP\Student\Instruction\Strings;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\FrameModel;

class GETCHARInstruction extends Instruction
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
        $sourceValue = null;
        $indexValue = null;

        if ($this->source instanceof ConstantArgument) {
            $sourceValue = $this->source->getValue();
        } else {
            $frame = $this->source->getFrame();
            $name = $this->source->getValue();
            $variable = $this->frameModel->getVariable($frame, $name);
            $sourceValue = $variable->getValue();
        }

        if ($this->index instanceof ConstantArgument) {
            $indexValue = $this->index->getValue();
        } else {
            $frame = $this->index->getFrame();
            $name = $this->index->getValue();
            $variable = $this->frameModel->getVariable($frame, $name);
            $indexValue = $variable->getValue();
        }

        $result = $sourceValue[$indexValue];

        $this->frameModel->setVariable($this->destination->getFrame(), $this->destination->getValue(), $result);
    }
}
