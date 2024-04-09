<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student\Instruction\IO;

use IPP\Core\Interface\InputReader;
use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\TypeArgument;
use IPP\Student\Exception\OperandTypeException;
use IPP\Student\FrameModel;

/**
 * READ instruction class.
 */
class READInstruction extends Instruction
{
    private VariableArgument $destination;
    private TypeArgument $type;

    private FrameModel $frameModel;
    private InputReader $stdin;

    public function __construct(int $order, VariableArgument $destination, TypeArgument $type, FrameModel $frameModel, InputReader $stdin)
    {
        $this->order = $order;
        $this->destination = $destination;
        $this->type = $type;
        $this->frameModel = $frameModel;
        $this->stdin = $stdin;
    }

    public function execute(): void
    {
        $value = null;

        switch ($this->type->getValue()) {
            case 'int':
                $value = $this->stdin->readInt();
                break;
            case 'bool':
                $value = $this->stdin->readBool();
                break;
            case 'string':
                $value = $this->stdin->readString();
                break;
            default:
                throw new OperandTypeException("Invalid type: {$this->type->getValue()}");
        }

        $this->frameModel->setVariable($this->destination->getFrame(), (string)$this->destination->getValue(), $value);
    }
}
