<?php

namespace IPP\Student;

use IPP\Student\Variable;

class Frame
{
    private array $frame;

    public function __construct()
    {
        $this->frame = [];
    }

    public function addVariable(Variable $variable): void
    {
        $name = $variable->getName();
        $this->frame[$name] = $variable;
    }

    public function getVariable(string $name): Variable
    {
        return $this->frame[$name];
    }

    public function containsVariable(string $name): bool
    {
        return isset($this->frame[$name]);
    }
}
