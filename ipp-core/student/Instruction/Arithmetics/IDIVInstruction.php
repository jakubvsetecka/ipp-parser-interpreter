<?php

namespace IPP\Student\Instruction\Arithmetics;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Exception\OperandValueException;
use IPP\Student\FrameModel;

class IDIVInstruction extends Instruction
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
            $name = $this->source1->getValue();
            $frame = $this->source1->getFrame();
            $variable = $this->frameModel->getVariable($frame, $name);
            $value1 = $variable->getValue();
        }

        if ($this->source2 instanceof ConstantArgument) {
            $value2 = $this->source2->getValue();
        } else {
            $name = $this->source2->getValue();
            $frame = $this->source2->getFrame();
            $variable = $this->frameModel->getVariable($frame, $name);
            $value2 = $variable->getValue();
        }

        if ($value2 === 0) {
            throw new OperandValueException('Division by zero.');
        }

        $result = intdiv($value1, $value2);

        $name = $this->destination->getValue();
        $frame = $this->destination->getFrame();
        $variable = $this->frameModel->getVariable($frame, $name);
        $variable->setValue($result);
    }
}
