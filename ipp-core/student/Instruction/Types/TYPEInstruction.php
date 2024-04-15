<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student\Instruction\Types;

use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\ConstantArgument;
use IPP\Student\FrameModel;

/**
 * TYPE instruction class.
 */
class TYPEInstruction extends Instruction
{
    private VariableArgument $destination;
    private ConstantArgument|VariableArgument $source;

    private FrameModel $frameModel;

    public function __construct(int $order, VariableArgument $destination, ConstantArgument|VariableArgument $source, FrameModel $frameModel)
    {
        $this->order = $order;
        $this->destination = $destination;
        $this->source = $source;
        $this->frameModel = $frameModel;
    }

    public function execute(): void
    {
        $value = null;
        $defined = true;

        if ($this->source instanceof ConstantArgument) {
            $value = $this->source->getValue();
        } else {
            $frame = $this->source->getFrame();
            $name = $this->source->getValue();
            $variable = $this->frameModel->getVariable($frame, (string)$name);
            if ($variable->isDefined()) {
                $value = $variable->getValue();
            } else {
                $defined = false;
            }
        }

        $result = gettype($value);

        if (!$defined) {
            $result = '';
        } else {
            switch ($result) {
                case 'integer':
                    $result = 'int';
                    break;
                case 'boolean':
                    $result = 'bool';
                    break;
                case 'string':
                    $result = 'string';
                    break;
                case 'NULL':
                    $result = 'nil';
                    break;
                default:
                    $result = 'unknown';
                    break;
            }
        }

        $this->frameModel->setVariable($this->destination->getFrame(), (string)$this->destination->getValue(), $result);
    }
}
