<?php

namespace IPP\Student;

use IPP\Core\Interface\OutputWriter;

abstract class Instruction
{
    protected int $order;

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
    public function print(OutputWriter $out)
    {
        $simpleClassName = $this->getSimpleName(get_class($this));
        $out->writeString($simpleClassName . "(" . $this->order . ")" . ":\n");

        $reflectionClass = new \ReflectionClass($this);
        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            if (!$property->isPublic()) {
                $property->setAccessible(true); // Make non-public properties accessible
            }

            $propertyName = $property->getName();

            if ($propertyName === 'frameModel' || $propertyName === 'scheduler' || $propertyName === 'stderr' || $propertyName === 'stdout' || $propertyName === 'stdin' || $propertyName === 'programCounter' || $propertyName === 'callStack' || $propertyName === 'dataStack') {
                continue;
            }

            $value = $property->getValue($this);
            $propertyTypeName = $this->getPropertyTypeName($property);
            $simplePropertyTypeName = $this->getSimpleName($propertyTypeName);

            $out->writeString("\t" . $propertyName . " (" . $simplePropertyTypeName . "):\n");

            // If the property is an object, iterate its attributes
            if (is_object($value)) {
                $this->printObjectAttributes($value, $out);
            } else {
                // For non-object values, just print the value
                $out->writeString("\t\tValue: " . $value . "\n");
            }
        }

        $out->writeString("\n");
    }

    private function getPropertyTypeName(\ReflectionProperty $property): string
    {
        $type = $property->getType();
        if (!$type) {
            return 'mixed';
        }

        $typeName = $type instanceof \ReflectionNamedType ? $type->getName() : 'mixed';
        return $typeName;
    }

    private function printObjectAttributes($object, OutputWriter $out): void
    {
        $reflectionClass = new \ReflectionClass($object);
        $attributes = $reflectionClass->getProperties();
        foreach ($attributes as $attribute) {
            if (!$attribute->isPublic()) {
                $attribute->setAccessible(true);
            }

            $attrName = $attribute->getName();
            $attrValue = $attribute->getValue($object);
            $attrType = $this->getPropertyTypeName($attribute);

            if (is_bool($attrValue)) {
                $attrValue = $attrValue ? 'true' : 'false';
            } else if ($attrValue === null) {
                $attrValue = 'null';
            }

            $out->writeString("\t\t" . $attrName . " (" . $attrType . "): " . $attrValue . "\n");
        }
    }

    private function getSimpleName(string $name): string
    {
        $simpleName = basename(str_replace('\\', '/', $name));
        // Use regex to remove everything from the last uppercase letter onwards
        return preg_replace('/[A-Z][^A-Z]*$/', '', $simpleName);
    }
}
