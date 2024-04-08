<?php

namespace IPP\Student;

use IPP\Student\Exception\FrameException;
use IPP\Student\Frame;

class FrameStack
{
    /** @var Frame[] */
    private array $stack;

    public function __construct()
    {
        $this->stack = [];
    }

    public function __toString(): string
    {
        $output = '';
        $output .= sprintf("Number of frames: %d\n", count($this->stack));
        foreach ($this->stack as $frame) {
            $output .= sprintf("%s\n", $frame);
        }
        return $output;
    }

    public function push(Frame $frame): void
    {
        array_push($this->stack, $frame);
    }

    public function pop(): Frame
    {
        if (empty($this->stack)) {
            throw new FrameException("Frame stack is empty.");
        }
        return array_pop($this->stack);
    }

    public function top(): Frame
    {
        if (empty($this->stack)) {
            throw new FrameException("Frame stack is empty.");
        }
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
