<?php

namespace IPP\Student\Instruction\Arithmetics;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Exception\OperandTypeException;
use IPP\Student\Exception\StringOperationException;
use IPP\Student\FrameModel;

class INT2CHARInstruction extends Instruction
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
            $variable = $this->frameModel->getVariable($frame, (string)$name);
            $value = $variable->getValue();
        }

        if (is_int($value) === false) {
            throw new OperandTypeException('Value must be an integer');
        }

        if (($result = mb_chr($value, $encoding = 'UTF-8')) == false) {
            throw new StringOperationException('Invalid character code');
        }

        $name = $this->destination->getValue();
        $frame = $this->destination->getFrame();
        $variable = $this->frameModel->getVariable($frame, (string)$name);
        $variable->setValue($result);
    }
}
