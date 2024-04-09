<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student\Instruction\DataFrame;

use IPP\Student\Instruction;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\DataStack;
use IPP\Student\FrameModel;

/**
 * PUSHS instruction class.
 */
class PUSHSInstruction extends Instruction
{
    private ConstantArgument|VariableArgument $source;

    private DataStack $dataStack;
    private FrameModel $frameModel;

    public function __construct(int $order, ConstantArgument|VariableArgument $source, DataStack $dataStack, FrameModel $frameModel)
    {
        $this->order = $order;
        $this->source = $source;
        $this->dataStack = $dataStack;
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

        $this->dataStack->push($value);
    }
}
