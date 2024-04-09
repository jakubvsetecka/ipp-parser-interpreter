<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student;

use IPP\Student\Exception\MissingValueException;

/**
 * Variable is used to store a variable name and its value in the Frame class.
 */
class Variable
{
    private string $name;
    private string|int|bool|null $value;
    private bool $defined;

    public function __construct(string $name, string|int|bool|null $value, bool $defined = true)
    {
        $this->name = $name;
        $this->value = $value;
        $this->defined = $defined;
    }

    public function __toString()
    {
        return sprintf("%s %s", $this->name, $this->value);
    }

    public function setValue(string|int|bool|null $value): void
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
