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

    public function __toString(): string
    {
        if (empty($this->frame)) {
            return "No variables stored.\n";
        }

        $nameMaxLength = 4; // Minimum length for "Name"
        $valueMaxLength = 5; // Minimum length for "Value"

        foreach ($this->frame as $variable) {
            $nameMaxLength = max($nameMaxLength, strlen((string)$variable->getName()));
            $valueMaxLength = max($valueMaxLength, strlen((string)$variable->getValue()));
        }

        // Create the header row
        $header = sprintf("| %-' {$nameMaxLength}s | %-' {$valueMaxLength}s |\n", 'Name', 'Value');
        $line = sprintf("+-%'-{$nameMaxLength}s-+-%'-{$valueMaxLength}s-+\n", '', ''); // Corrected to only use '-' for separator line
        $output = $line . $header . $line;

        foreach ($this->frame as $variable) {
            if ($variable->getValue() === null) {
                $variable->setValue('nil');
            }
            $output .= sprintf(
                "| %-' {$nameMaxLength}s | %-' {$valueMaxLength}s |\n",
                (string)$variable->getName(),
                (string)$variable->getValue()
            );
        }

        $output .= $line; // End table with line

        return $output;
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
