<?php

namespace IPP\Student\Instruction\Strings;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Exception\StringOperationException;
use IPP\Student\FrameModel;

class STRLENInstruction extends Instruction
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
            $frame = $this->source->getFrame();
            $name = $this->source->getValue();
            $variable = $this->frameModel->getVariable($frame, $name);
            $value = $variable->getValue();
        }

        if (!is_string($value)) {
            throw new StringOperationException('Argument must be a string.');
        }

        $result = strlen($value);

        $this->frameModel->setVariable($this->destination->getFrame(), $this->destination->getValue(), $result);
    }
}
