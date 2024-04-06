<?php

namespace IPP\Student;

class CallStack
{
    private array $stack = [];

    public function push(int $index): void
    {
        $this->stack[] = $index;
    }

    public function pop(): int
    {
        return array_pop($this->stack);
    }

    public function top(): int
    {
        return end($this->stack);
    }

    public function isEmpty(): bool
    {
        return empty($this->stack);
    }
}
