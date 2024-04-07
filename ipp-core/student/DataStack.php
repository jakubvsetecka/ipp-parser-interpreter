<?php

namespace IPP\Student;

class DataStack
{
    private array $stack = [];

    public function push(int|string|bool|null $value): void
    {
        $this->stack[] = $value;
    }

    public function pop(): int|string|bool|null
    {
        return array_pop($this->stack);
    }

    public function top(): int|string|bool|null
    {
        return end($this->stack);
    }

    public function isEmpty(): bool
    {
        return empty($this->stack);
    }
}
