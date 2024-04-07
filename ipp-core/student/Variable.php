<?php

namespace IPP\Student;

class Variable
{
    private string $name;
    private ?string $value;
    private bool $defined;

    public function __construct(string $name, string $value = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->defined = $value !== null;
    }

    public function __toString()
    {
        return sprintf("%s %s", $this->name, $this->value);
    }

    public function setValue($value): void
    {
        $this->value = $value;
        $this->defined = true;
    }

    public function getValue(): string
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
