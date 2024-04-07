<?php

namespace IPP\Student\Instruction\Strings;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\FrameModel;

class SETCHARInstruction extends Instruction
{
    private VariableArgument $destination;
    private ConstantArgument|VariableArgument $index;
    private ConstantArgument|VariableArgument $symbol;

    private FrameModel $frameModel;

    public function __construct(int $order, VariableArgument $destination, ConstantArgument|VariableArgument $index, ConstantArgument|VariableArgument $symbol, FrameModel $frameModel)
    {
        $this->order = $order;
        $this->destination = $destination;
        $this->index = $index;
        $this->symbol = $symbol;
        $this->frameModel = $frameModel;
    }

    public function execute(): void
    {
        $indexValue = null;
        $symbolValue = null;

        if ($this->index instanceof ConstantArgument) {
            $indexValue = $this->index->getValue();
        } else {
            $frame = $this->index->getFrame();
            $name = $this->index->getValue();
            $variable = $this->frameModel->getVariable($frame, $name);
            $indexValue = $variable->getValue();
        }

        if ($this->symbol instanceof ConstantArgument) {
            $symbolValue = $this->symbol->getValue();
        } else {
            $frame = $this->symbol->getFrame();
            $name = $this->symbol->getValue();
            $variable = $this->frameModel->getVariable($frame, $name);
            $symbolValue = $variable->getValue();
        }

        $destinationValue = null;

        if ($this->destination instanceof ConstantArgument) {
            $destinationValue = $this->destination->getValue();
        } else {
            $frame = $this->destination->getFrame();
            $name = $this->destination->getValue();
            $variable = $this->frameModel->getVariable($frame, $name);
            $destinationValue = $variable->getValue();
        }

        $destinationValue[$indexValue] = $symbolValue;

        $this->frameModel->setVariable($this->destination->getFrame(), $this->destination->getValue(), $destinationValue);
    }
}
