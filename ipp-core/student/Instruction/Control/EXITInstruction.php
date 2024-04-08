<?php

namespace IPP\Student\Instruction\Control;

use IPP\Student\Instruction;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Exception\OperandValueException;
use IPP\Student\FrameModel;
use IPP\Student\Scheduler;

class EXITInstruction extends Instruction
{
    private ConstantArgument|VariableArgument $return_code;
    private FrameModel $frameModel;
    private Scheduler $scheduler;

    public function __construct(int $order, ConstantArgument|VariableArgument $return_code, FrameModel $frameModel, Scheduler $scheduler)
    {
        $this->order = $order;
        $this->return_code = $return_code;
        $this->frameModel = $frameModel;
        $this->scheduler = $scheduler;
    }

    public function execute(): void
    {
        $value = null;

        if ($this->return_code instanceof ConstantArgument) {
            $value = $this->return_code->getValue();
        } else {
            $name = $this->return_code->getValue();
            $frame = $this->return_code->getFrame();
            $variable = $this->frameModel->getVariable($frame, $name);
            $value = $variable->getValue();
        }

        if (!is_int($value)) {
            throw new OperandValueException('Return code must be an integer');
        }

        if ($value < 0 || $value > 9) {
            throw new OperandValueException('Return code must be in range 0-255');
        }

        $this->scheduler->exit($value);
    }
}
