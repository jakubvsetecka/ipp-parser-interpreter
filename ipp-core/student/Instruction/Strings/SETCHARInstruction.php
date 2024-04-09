<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student\Instruction\Strings;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Exception\OperandTypeException;
use IPP\Student\Exception\StringOperationException;
use IPP\Student\FrameModel;

/**
 * SETCHAR instruction class.
 */
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
            $variable = $this->frameModel->getVariable($frame, (string)$name);
            $indexValue = $variable->getValue();
        }

        if ($this->symbol instanceof ConstantArgument) {
            $symbolValue = $this->symbol->getValue();
        } else {
            $frame = $this->symbol->getFrame();
            $name = $this->symbol->getValue();
            $variable = $this->frameModel->getVariable($frame, (string)$name);
            $symbolValue = $variable->getValue();
        }

        $destinationValue = null;


        $frame = $this->destination->getFrame();
        $name = $this->destination->getValue();
        $variable = $this->frameModel->getVariable($frame, (string)$name);
        $destinationValue = $variable->getValue();


        if (!is_string($destinationValue)) {
            throw new OperandTypeException('Argument must be a string.');
        }

        if (!is_int($indexValue)) {
            throw new OperandTypeException('Index must be an integer.');
        }

        if ($indexValue < 0 || $indexValue >= strlen((string)$destinationValue) || strlen((string)$symbolValue) === 0) {
            throw new StringOperationException('Index out of bounds.');
        }

        $destinationValue[$indexValue] = $symbolValue;

        $this->frameModel->setVariable($this->destination->getFrame(), (string)$this->destination->getValue(), $destinationValue);
    }
}
