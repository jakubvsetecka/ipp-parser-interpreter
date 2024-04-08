<?php

namespace IPP\Student;

use RuntimeException;

class CallStack
{
    /** @var int[] */
    private array $stack = [];

    public function push(int $index): void
    {
        $this->stack[] = $index;
    }

    public function pop(): int
    {
        $result = array_pop($this->stack);
        if ($result === null) {
            throw new RuntimeException('Call stack is empty');
        }
        return $result;
    }

    public function top(): int
    {
        $result = end($this->stack);
        if ($result === false) {
            throw new RuntimeException('Call stack is empty');
        }
        return $result;
    }

    public function isEmpty(): bool
    {
        return empty($this->stack);
    }
}
