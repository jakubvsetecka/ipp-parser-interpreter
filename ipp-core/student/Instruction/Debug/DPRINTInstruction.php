<?php

namespace IPP\Student\Instruction\Debug;

use IPP\Core\Interface\OutputWriter;
use IPP\Student\Instruction;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\FrameModel;

class DPRINTInstruction extends Instruction
{
    private ConstantArgument|VariableArgument $source;

    private FrameModel $frameModel;
    private OutputWriter $stderr;

    public function __construct(int $order, ConstantArgument|VariableArgument $source, FrameModel $frameModel, OutputWriter $stderr)
    {
        $this->order = $order;
        $this->source = $source;
        $this->frameModel = $frameModel;
        $this->stderr = $stderr;
    }

    public function execute(): void
    {
        if ($this->source instanceof ConstantArgument) {
            $this->stderr->writeString($this->source->getValue());
        } else {
            $frame = $this->source->getFrame();
            $name = $this->source->getValue();
            $variable = $this->frameModel->getVariable($frame, $name);
            $this->stderr->writeString($variable->getValue());
        }
    }
}
