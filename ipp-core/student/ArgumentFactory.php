<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student;

use IPP\Student\Argument\ConstantArgument;
use IPP\Student\Argument\LabelArgument;
use IPP\Student\Argument\TypeArgument;
use IPP\Student\Argument\VariableArgument;
use IPP\Student\Exception\XMLStructureException;

/**
 * Argument factory for creating Argument objects based on their type.
 */
class ArgumentFactory
{
    /**
     * Map of supported types with their regex patterns and corresponding Argument classes
     * @var array<string, array{pattern: string, cast: string}>
     */
    private static array $map = [
        'string' => [
            'pattern' => '/^(?:[^\\\\#\s]|\\\\[0-9]{3})*$/', // Matches string constants with the described constraints
            'cast' => ConstantArgument::class
        ],
        'int' => [
            'pattern' => '/^[-+]?\d+$/', // Matches signed or unsigned integers
            'cast' => ConstantArgument::class
        ],
        'bool' => [
            'pattern' => '/^true|false$/', // Matches boolean constants true or false
            'cast' => ConstantArgument::class
        ],
        'nil' => [
            'pattern' => '/^nil$/', // Matches the nil type
            'cast' => ConstantArgument::class
        ],
        'label' => [
            'pattern' => '/^[\w\-]+$/',
            'cast' => LabelArgument::class
        ],
        'type' => [
            'pattern' => '/^int|bool|string|nil$/', // Assuming 'type' operand expects a type name
            'cast' => TypeArgument::class
        ],
        'var' => [
            'pattern' => '/^(GF|TF|LF)@[\w\-]+$/',
            'cast' => VariableArgument::class
        ],
    ];

    public function create(string $type, string $value): Argument
    {
        if (!array_key_exists($type, self::$map) || !isset(self::$map[$type])) {
            throw new XMLStructureException("Unsupported type: $type");
        }

        $typeInfo = self::$map[$type];
        $value = trim($value);

        // Match regex
        if (preg_match($typeInfo['pattern'], $value) === 0) {
            throw new XMLStructureException("Invalid value: $value");
        }

        // Convert the string to the appropriate type
        $convertedValue = $this->convertToProperType($type, $value);

        // Use the converted value to instantiate the Argument
        $argument = new $typeInfo['cast']($convertedValue);

        assert($argument instanceof Argument);

        return $argument;
    }

    private function convertToProperType(string $type, string $value): mixed
    {
        switch ($type) {
            case 'int':
                return (int)$value;
            case 'bool':
                // This uses filter_var to convert to boolean. True values are "1", "true", "on", and "yes". Everything else is false.
                return $value === 'true' ? true : false;
            case 'string':
                return $this->decodeEscapeSequences($value);
            case 'nil':
                return null;
            default:
                return $value;
        }
    }

    private function decodeEscapeSequences(string $string): ?string
    {
        return preg_replace_callback('/\\\\(\d{3})/', function ($matches) {
            return chr((int)$matches[1]);
        }, $string);
    }
}
