<?php

namespace IPP\Student\Instruction\IO;

use IPP\Core\Interface\InputReader;
use IPP\Student\Instruction;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Argument\TypeArgument;
use IPP\Student\FrameModel;

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
                $value = 'nil'; // TODO: implement nil
        }

        $this->frameModel->setVariable($this->destination->getFrame(), $this->destination->getValue(), $value);
    }
}
