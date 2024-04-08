<?php

namespace IPP\Student\Instruction\Strings;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Exception\OperandTypeException;
use IPP\Student\Exception\StringOperationException;
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
            $variable = $this->frameModel->getVariable($frame, (string)$name);
            $sourceValue = $variable->getValue();
        }

        if ($this->index instanceof ConstantArgument) {
            $indexValue = $this->index->getValue();
        } else {
            $frame = $this->index->getFrame();
            $name = $this->index->getValue();
            $variable = $this->frameModel->getVariable($frame, (string)$name);
            $indexValue = $variable->getValue();
        }

        if (!is_string($sourceValue)) {
            throw new OperandTypeException('Argument must be a string.');
        }

        if (!is_int($indexValue)) {
            throw new OperandTypeException('Index must be an integer.');
        }

        if ($indexValue < 0 || $indexValue >= strlen($sourceValue)) {
            throw new StringOperationException('Index out of bounds.');
        }

        $result = $sourceValue[$indexValue];

        $this->frameModel->setVariable($this->destination->getFrame(), (string)$this->destination->getValue(), $result);
    }
}
