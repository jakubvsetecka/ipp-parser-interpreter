<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student\Instruction\Arithmetics;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Exception\OperandTypeException;
use IPP\Student\Exception\StringOperationException;
use IPP\Student\FrameModel;

/**
 * STR2INT instruction.
 */
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
            $variable = $this->frameModel->getVariable($frame, (string)$name);
            $value = $variable->getValue();
        }

        if ($this->index instanceof ConstantArgument) {
            $index = $this->index->getValue();
        } else {
            $name = $this->index->getValue();
            $frame = $this->index->getFrame();
            $variable = $this->frameModel->getVariable($frame, (string)$name);
            $index = $variable->getValue();
        }

        if (!is_string($value)) {
            throw new OperandTypeException('Argument is not a string');
        }

        if (!is_int($index)) {
            throw new OperandTypeException('Argument is not an integer');
        }

        if ($index < 0 || $index >= mb_strlen($value)) {
            throw new StringOperationException('Index out of range');
        }

        if (($result = mb_ord((string)$value[$index], 'UTF-8')) == false) {
            throw new StringOperationException('Invalid character code');
        }

        $name = $this->destination->getValue();
        $frame = $this->destination->getFrame();
        $variable = $this->frameModel->getVariable($frame, (string)$name);
        $variable->setValue($result);
    }
}
