<?php

namespace IPP\Student;

class DataStack
{
    private array $stack = [];

    public function push(int $value): void
    {
        $this->stack[] = $value;
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
