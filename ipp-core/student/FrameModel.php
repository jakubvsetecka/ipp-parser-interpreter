<?php

namespace IPP\Student;

use IPP\Student\Variable;
use IPP\Student\FrameStack;
use IPP\Student\Frame;
use IPP\Student\Exception\FrameException;

class FrameModel
{
    private Frame $GF;
    private ?Frame $TF;
    private FrameStack $LF;

    public function __construct()
    {
        $this->GF = new Frame();
        $this->LF = new FrameStack();
        $this->TF = null;
    }

    public function __toString()
    {
        if ($this->TF === null) {
            return sprintf("GF:\n%s\nTF:\n%s\nLF:\n%s\n", $this->GF, "Undefined\n", $this->LF);
        }
        return sprintf("GF:\n%s\nLF:\n%s\nTF:\n%s\n", $this->GF, $this->LF, $this->TF);
    }

    public function createFrame(): void
    {
        $this->TF = new Frame();
    }

    public function pushFrame(): void
    {
        if ($this->TF === null) {
            throw new FrameException();
        }
        $this->LF->push($this->TF);
        $this->TF = null;
    }

    public function popFrame(): void
    {
        $frame = $this->LF->pop();
        if ($frame == null) {
            throw new FrameException();
        }
        $this->TF = $frame;
    }

    public function addVariable(string $frame, string $name, string|int|bool|null $value = null, bool $definition = true): void
    {
        switch ($frame) {
            case 'GF':
                $this->GF->addVariable(new Variable($name, $value, $definition));
                break;
            case 'TF':
                if ($this->TF === null) {
                    throw new FrameException('Temporary frame is not defined');
                }
                $this->TF->addVariable(new Variable($name, $value, $definition));
                break;
            case 'LF':
                $this->LF->top()->addVariable(new Variable($name, $value, $definition));
                break;
            default:
                throw new FrameException(sprintf('Invalid frame %s', $frame));
        }
    }

    public function getVariable(string $frame, string $name): Variable
    {
        switch ($frame) {
            case 'GF':
                return $this->GF->getVariable($name);
            case 'TF':
                if ($this->TF === null) {
                    throw new FrameException('Temporary frame is not defined');
                }
                return $this->TF->getVariable($name);
            case 'LF':
                if ($this->LF->containsVariable($name)) {
                    return $this->LF->top()->getVariable($name);
                } else {
                    throw new FrameException(sprintf('Variable %s is not defined', $name));
                }
            default:
                throw new FrameException(sprintf('Invalid frame %s', $frame));
        }
    }

    public function setVariable(string $frame, string $name, string|int|bool|null $value): void
    {
        switch ($frame) {
            case 'GF':
                $this->GF->getVariable($name)->setValue($value);
                break;
            case 'TF':
                if ($this->TF === null) {
                    throw new FrameException('Temporary frame is not defined');
                }
                $this->TF->getVariable($name)->setValue($value);
                break;
            case 'LF':
                if ($this->LF->containsVariable($name)) {
                    $this->LF->top()->getVariable($name)->setValue($value);
                } else {
                    throw new FrameException(sprintf('Variable %s is not defined', $name));
                }
                break;
            default:
                throw new FrameException(sprintf('Invalid frame %s', $frame));
        }
    }
}
