<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student\Instruction\Debug;

use IPP\Core\Interface\OutputWriter;
use IPP\Student\Instruction;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\FrameModel;

/**
 * DPRINT instruction class.
 */
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
        $value = null;
        if ($this->source instanceof ConstantArgument) {
            $value = $this->source->getValue();
        } else {
            $frame = $this->source->getFrame();
            $name = $this->source->getValue();
            $variable = $this->frameModel->getVariable($frame, (string)$name);
            $value = $variable->getValue();
        }
        $value = $this->toString($value);
        $this->stderr->writeString($value);
    }

    private function toString(bool|int|string|null $value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        } elseif (is_int($value)) {
            return (string) $value;
        } elseif (is_null($value)) {
            return 'nil';
        }

        return (string) $value;
    }
}
