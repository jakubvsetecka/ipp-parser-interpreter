<?php

namespace IPP\Student;

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
    public function print()
    {
        $simpleClassName = $this->getSimpleName(get_class($this));
        echo "Instruction(" . $this->order . "): " . $simpleClassName . "\n";

        $reflectionClass = new \ReflectionClass($this);
        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            if (!$property->isPublic()) {
                $property->setAccessible(true); // Make non-public properties accessible
            }

            $value = $property->getValue($this);
            $propertyName = $property->getName();
            $propertyTypeName = $this->getPropertyTypeName($property);
            $simplePropertyTypeName = $this->getSimpleName($propertyTypeName);

            echo "\t" . $propertyName . " (" . $simplePropertyTypeName . "):\n";

            // If the property is an object, iterate its attributes
            if (is_object($value)) {
                $this->printObjectAttributes($value);
            } else {
                // For non-object values, just print the value
                echo "\t\tValue: " . $value . "\n";
            }
        }

        echo "\n";
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

    private function printObjectAttributes($object): void
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

            echo "\t\t" . $attrName . " (" . $attrType . "): " . $attrValue . "\n";
        }
    }

    private function getSimpleName(string $name): string
    {
        $simpleName = basename(str_replace('\\', '/', $name));
        // Use regex to remove everything from the last uppercase letter onwards
        return preg_replace('/[A-Z][^A-Z]*$/', '', $simpleName);
    }
}
