<?php

namespace IPP\Student;

class ProgramCounter
{
    private int $counter = 0;

    public function increment(): void
    {
        $this->counter++;
    }

    public function getCounter(): int
    {
        return $this->counter;
    }

    public function setCounter(int $counter): void
    {
        $this->counter = $counter;
    }
}
