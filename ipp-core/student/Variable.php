<?php

namespace IPP\Student;

use IPP\Student\Exception\MissingValueException;

class Variable
{
    private string $name;
    private string|int|bool|null $value;
    private bool $defined;

    public function __construct(string $name, string|int|bool|null $value)
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

    public function getValue(): string|int|bool|null
    {
        if ($this->defined === false) {
            throw new MissingValueException("Variable: {$this->name} is not defined.");
        }
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
