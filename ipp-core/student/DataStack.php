<?php

namespace IPP\Student;

class DataStack
{
    private array $stack = [];

    public function push(string $value): void
    {
        $this->stack[] = $value;
    }

    public function pop(): string
    {
        return array_pop($this->stack);
    }

    public function top(): string
    {
        return end($this->stack);
    }

    public function isEmpty(): bool
    {
        return empty($this->stack);
    }
}
