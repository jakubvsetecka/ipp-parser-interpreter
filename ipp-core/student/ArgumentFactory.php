<?php

namespace IPP\Student;

use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Argument\LabelArgument;
use IPP\Student\Argument\TypeArgument;
use IPP\Student\Argument\VariableArgument;

class ArgumentFactory
{
    private static $map = [
        'string' => ['pattern' => '/^.+$/', 'cast' => ConstantArgument::class],
        'int' => ['pattern' => '/^.+$/', 'cast' => ConstantArgument::class],
        'bool' => ['pattern' => '/^.+$/', 'cast' => ConstantArgument::class],
        'nil' => ['pattern' => '/^.+$/', 'cast' => ConstantArgument::class],
        'label' => ['pattern' => '/^.+$/', 'cast' => LabelArgument::class],
        'type' => ['pattern' => '/^.+$/', 'cast' => TypeArgument::class],
        'var' => ['pattern' => '/^.+$/', 'cast' => VariableArgument::class],
    ];

    public static function create(string $type, string $value): Argument
    {
        if (!array_key_exists($type, self::$map) || !isset(self::$map[$type])) {
            throw new \Exception("Unsupported type: $type");
        }

        $typeInfo = self::$map[$type];
        // Match regex
        if (preg_match($typeInfo['pattern'], $value) === 0) {
            throw new \Exception("Invalid value: $value");
        }

        // Convert the string to the appropriate type
        $convertedValue = self::convertToProperType($type, $value);

        // Use the converted value to instantiate the Argument
        $argument = new $typeInfo['cast']($convertedValue);

        return $argument;
    }


    public static function convertToProperType(string $type, string $value)
    {
        switch ($type) {
            case 'int':
                return (int)$value;
            case 'bool':
                // This uses filter_var to convert to boolean. True values are "1", "true", "on", and "yes". Everything else is false.
                return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false;
            case 'string':
                return $value;
            case 'nil':
                return null;
            default:
                return $value;
        }
    }
}
