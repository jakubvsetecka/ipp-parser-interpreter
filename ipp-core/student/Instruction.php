<?php

namespace IPP\Student;

abstract class Instruction
{
    private int $order;
    private array $arguments;

    abstract public function execute(): void;

    public function __construct(string $order, array $arguments)
    {
        $this->order = $order;
        $this->arguments = $arguments;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Prints the instruction details.
     */
    public function print(): void
    {
        echo "Order: {$this->order}\n";
        echo "Arguments:\n";
        foreach ($this->arguments as $argument) {
            // Assuming each argument has a method `getValue` for its string representation
            echo " - " . $argument->getValue() . "\n";
        }
    }
}
