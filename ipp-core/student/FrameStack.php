<?php

namespace IPP\Student;

use IPP\Student\Frame;

class FrameStack
{
    private array $stack;

    public function __construct()
    {
        $this->stack = [];
    }

    public function push(Frame $frame): void
    {
        array_push($this->stack, $frame);
    }

    public function pop(): Frame
    {
        return array_pop($this->stack);
    }

    public function top(): Frame
    {
        return end($this->stack);
    }

    public function containsVariable(string $name): bool
    {
        foreach ($this->stack as $frame) {
            if ($frame->containsVariable($name)) {
                return true;
            }
        }

        return false;
    }
}