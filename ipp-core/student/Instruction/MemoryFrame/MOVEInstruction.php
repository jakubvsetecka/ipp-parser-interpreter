<?php

namespace IPP\Student\Instruction\MemoryFrame;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;

class MOVEInstruction extends Instruction
{
    private VariableArgument $destination;
    private ConstantArgument|VariableArgument $source;

    public function __construct(int $order, VariableArgument $destination, ConstantArgument|VariableArgument $source)
    {
        parent::__construct($order);
        $this->destination = $destination;
        $this->source = $source;
    }

    public function execute(): void
    {
        global $FRAME_MODEL;

        $frame = $this->destination->getFrame();
        $name = $this->destination->getValue();
        $value = $this->source->getValue();
    }
}
