<?php

namespace IPP\Student;

use IPP\Student\Variable;
use IPP\Student\FrameStack;
use IPP\Student\Frame;

class FrameModel
{
    private Frame $GF;
    private Frame $TF;
    private FrameStack $LF;

    public function __construct()
    {
        $this->GF = new Frame();
        $this->LF = new FrameStack();
        $this->TF = null;
    }

    public function createFrame(): void
    {
        $this->TF = new Frame();
    }

    public function pushFrame(): void
    {
        $this->LF->push($this->TF);
        $this->TF = null;
    }

    public function popFrame(): void
    {
        $this->TF = $this->LF->pop();
    }

    public function addVariable(string $frame, string $name, string $value = null): void
    {
        switch ($frame) {
            case 'GF':
                $this->GF->addVariable(new Variable($name, $value));
                break;
            case 'TF':
                if ($this->TF === null) {
                    throw new \InvalidArgumentException('Temporary frame is not defined');
                }
                $this->TF->addVariable(new Variable($name, $value));
                break;
            case 'LF':
                $this->LF->top()->addVariable(new Variable($name, $value));
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Invalid frame %s', $frame));
        }
    }

    public function getVariable(string $frame, string $name): Variable
    {
        switch ($frame) {
            case 'GF':
                return $this->GF->getVariable($name);
            case 'TF':
                if ($this->TF === null) {
                    throw new \InvalidArgumentException('Temporary frame is not defined');
                }
                return $this->TF->getVariable($name);
            case 'LF':
                if ($this->LF->containsVariable($name)) {
                    return $this->LF->top()->getVariable($name);
                } else {
                    throw new \InvalidArgumentException(sprintf('Variable %s is not defined', $name));
                }
            default:
                throw new \InvalidArgumentException(sprintf('Invalid frame %s', $frame));
        }
    }

    public function setVariable(string $frame, string $name, int $value): void
    {
        switch ($frame) {
            case 'GF':
                $this->GF->getVariable($name)->setValue($value);
                break;
            case 'TF':
                if ($this->TF === null) {
                    throw new \InvalidArgumentException('Temporary frame is not defined');
                }
                $this->TF->getVariable($name)->setValue($value);
                break;
            case 'LF':
                if ($this->LF->containsVariable($name)) {
                    $this->LF->top()->getVariable($name)->setValue($value);
                } else {
                    throw new \InvalidArgumentException(sprintf('Variable %s is not defined', $name));
                }
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Invalid frame %s', $frame));
        }
    }
}