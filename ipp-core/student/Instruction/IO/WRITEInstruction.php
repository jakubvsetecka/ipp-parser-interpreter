<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student\Instruction\IO;

use IPP\Core\Interface\OutputWriter;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\FrameModel;

/**
 * WRITE instruction class.
 */
class WRITEInstruction extends Instruction
{
    private ConstantArgument|VariableArgument $source;

    private FrameModel $frameModel;
    private OutputWriter $stdout;

    public function __construct(int $order, ConstantArgument|VariableArgument $source, FrameModel $frameModel, OutputWriter $stdout)
    {
        $this->order = $order;
        $this->source = $source;
        $this->frameModel = $frameModel;
        $this->stdout = $stdout;
    }

    public function execute(): void
    {
        $value = null;
        if ($this->source instanceof ConstantArgument) {
            $value = $this->source->getValue();
        } else {
            $frame = $this->source->getFrame();
            $name = $this->source->getValue();
            $variable = $this->frameModel->getVariable($frame, (string)$name);
            $value = $variable->getValue();
        }

        switch (gettype($value)) {
            case 'boolean':
                $this->stdout->writeBool($value);
                break;
            case 'integer':
                $this->stdout->writeInt($value);
                break;
            case 'string':
                $this->stdout->writeString($value);
                break;
            case 'NULL':
                $this->stdout->writeString('');
                break;
            default:
                $this->stdout->writeString('');
        }
    }
}
