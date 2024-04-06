<?php

namespace IPP\Student;

use ReflectionClass;
use ReflectionProperty;

abstract class Instruction
{
    private int $order;

    abstract public function execute(): void;

    public function __construct(string $order)
    {
        $this->order = $order;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

    /**
     * Prints the instruction details.
     */
    public function print()
    {
        $className = get_class($this);
        // Replace backslashes with forward slashes and use basename to get the last part
        $simpleClassName = basename(str_replace('\\', '/', $className));

        // Optionally, remove "Instruction" from the end if it's always there
        $simpleClassName = str_replace('Instruction', '', $simpleClassName);

        echo "Instruction(" . $this->order . "): " . $simpleClassName . "\n";

        echo "Arguments:\n";
        $reflectionClass = new \ReflectionClass($this);
        #if no arguments:
        if (count($reflectionClass->getProperties(\ReflectionProperty::IS_PRIVATE)) == 0) {
            echo "\t" . "---\n";
        }
        foreach ($reflectionClass->getProperties(\ReflectionProperty::IS_PRIVATE) as $property) {
            $property->setAccessible(true); // Make private property accessible
            # tabulation first
            echo "\t" . $property->getName() . ": " . $property->getValue($this) . "\n";
        }

        echo "\n";
    }
}
