<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student\Instruction\Control;

use IPP\Student\Instruction;
use IPP\Student\Argument\LabelArgument;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Exception\OperandTypeException;
use IPP\Student\FrameModel;
use IPP\Student\Scheduler;

/**
 * JUMPIFEQ instruction class.
 */
class JUMPIFEQInstruction extends Instruction
{
    private LabelArgument $label;
    private ConstantArgument|VariableArgument $source1;
    private ConstantArgument|VariableArgument $source2;

    private Scheduler $scheduler;
    private FrameModel $frame_model;

    public function __construct(int $order, LabelArgument $label, ConstantArgument|VariableArgument $source1, ConstantArgument|VariableArgument $source2, Scheduler $scheduler, FrameModel $frame_model)
    {
        $this->order = $order;
        $this->label = $label;
        $this->source1 = $source1;
        $this->source2 = $source2;
        $this->scheduler = $scheduler;
        $this->frame_model = $frame_model;
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
            $variable = $this->frame_model->getVariable($frame, (string)$name);
            $value1 = $variable->getValue();
        }

        if ($this->source2 instanceof ConstantArgument) {
            $value2 = $this->source2->getValue();
        } else {
            $name = $this->source2->getValue();
            $frame = $this->source2->getFrame();
            $variable = $this->frame_model->getVariable($frame, (string)$name);
            $value2 = $variable->getValue();
        }

        if (gettype($value1) !== gettype($value2) && $value1 !== null && $value2 !== null) {
            throw new OperandTypeException('Types of values must match');
        }

        if ($value1 === $value2) {
            $this->scheduler->jump((string)$this->label->getValue());
        }
    }
}
