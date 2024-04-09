<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student;

use IPP\Student\Exception\SemanticException;
use IPP\Student\Exception\VariableException;
use IPP\Student\Variable;

/**
 * Frame representing a frame according to the IPP specification.
 */
class Frame
{
    /**
     * @var Variable[]
     */
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
            $name = $variable->getName();

            if ($variable->isDefined() === false) {
                $value = 'N/A';
            } else {
                $value = $variable->getValue();
            }

            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }

            if (is_null($value)) {
                $value = 'nil';
            }

            $output .= sprintf(
                "| %-' {$nameMaxLength}s | %-' {$valueMaxLength}s |\n",
                (string)$name,
                (string)$value
            );
        }

        $output .= $line; // End table with line

        return $output;
    }

    public function addVariable(Variable $variable): void
    {
        if ($this->containsVariable($variable->getName())) {
            throw new SemanticException();
        }
        $name = $variable->getName();
        $this->frame[$name] = $variable;
    }

    public function getVariable(string $name): Variable
    {
        if (!$this->containsVariable($name)) {
            throw new VariableException("Variable $name not found");
        }
        return $this->frame[$name];
    }

    public function containsVariable(string $name): bool
    {
        return isset($this->frame[$name]);
    }
}
