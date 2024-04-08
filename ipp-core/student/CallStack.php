<?php

namespace IPP\Student;

class CallStack
{
    private array $stack = [];
    private array $labels = [];

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

    public function addLabel(string $label, int $index): void
    {
        $this->labels[$label] = $index;
    }

    public function containsLabel(string $label): bool
    {
        return array_key_exists($label, $this->labels);
    }
}
