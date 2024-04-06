<?php

namespace IPP\Student;

class Variable
{
    private string $name;
    private string $value;
    private bool $defined;

    public function __construct(string $name, string $value = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->defined = $value !== null;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
        $this->defined = true;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isDefined(): bool
    {
        return $this->defined;
    }
}
