<?php

namespace IPP\Student\Instruction\IO;

use IPP\Core\Interface\OutputWriter;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Frame;
use IPP\Student\FrameModel;

class WRITEInstruction extends Instruction
{
    private ConstantArgument|VariableArgument $source;

    private FrameModel $frameModel;
    private OutputWriter $stdout;

    public function __construct(int $order, ConstantArgument|VariableArgument $source, FrameModel $frameModel, OutputWriter $stdout)
    {
        parent::__construct($order);
        $this->source = $source;
        $this->frameModel = $frameModel;
        $this->stdout = $stdout;
    }

    public function execute(): void
    {
        if ($this->source instanceof ConstantArgument) {
            $this->stdout->writeString($this->source->getValue());
        } else {
            $frame = $this->source->getFrame();
            $name = $this->source->getValue();
            $variable = $this->frameModel->getVariable($frame, $name);
            $this->stdout->writeString($variable->getValue());
        }
    }
}
