<?php

namespace IPP\Student;

use IPP\Student\Argument\LabelArgument;
use IPP\Student\Argument\SymbolArgument;
use IPP\Student\Argument\TypeArgument;
use IPP\Student\Argument\VariableArgument;

class ArgumentFactory
{
    private static $map = [
        'ADD' => [VariableArgument::class, SymbolArgument::class, SymbolArgument::class],
        'SUB' => [VariableArgument::class, SymbolArgument::class, SymbolArgument::class],
        'MUL' => [VariableArgument::class, SymbolArgument::class, SymbolArgument::class],
        'IDIV' => [VariableArgument::class, SymbolArgument::class, SymbolArgument::class],
        'LT' => [VariableArgument::class, SymbolArgument::class, SymbolArgument::class],
        'GT' => [VariableArgument::class, SymbolArgument::class, SymbolArgument::class],
        'EQ' => [VariableArgument::class, SymbolArgument::class, SymbolArgument::class],
        'AND' => [VariableArgument::class, SymbolArgument::class, SymbolArgument::class],
        'OR' => [VariableArgument::class, SymbolArgument::class, SymbolArgument::class],
        'NOT' => [VariableArgument::class, SymbolArgument::class],
        'INT2CHAR' => [VariableArgument::class, SymbolArgument::class],
        'STRI2INT' => [VariableArgument::class, SymbolArgument::class, SymbolArgument::class],
        'READ' => [VariableArgument::class, TypeArgument::class],
        'WRITE' => [SymbolArgument::class],
        'CONCAT' => [VariableArgument::class, SymbolArgument::class, SymbolArgument::class],
        'STRLEN' => [VariableArgument::class, SymbolArgument::class],
        'GETCHAR' => [VariableArgument::class, SymbolArgument::class, SymbolArgument::class],
        'SETCHAR' => [VariableArgument::class, SymbolArgument::class, SymbolArgument::class],
        'TYPE' => [VariableArgument::class, SymbolArgument::class],
        'LABEL' => [LabelArgument::class],
        'JUMP' => [LabelArgument::class],
        'JUMPIFEQ' => [LabelArgument::class, SymbolArgument::class, SymbolArgument::class],
        'JUMPIFNEQ' => [LabelArgument::class, SymbolArgument::class, SymbolArgument::class],
        'DPRINT' => [SymbolArgument::class],
        'BREAK' => [],
        'CREATEFRAME' => [],
        'PUSHFRAME' => [],
        'POPFRAME' => [],
        'DEFVAR' => [VariableArgument::class],
        'CALL' => [LabelArgument::class],
        'RETURN' => [],
        'PUSHS' => [SymbolArgument::class],
        'POPS' => [VariableArgument::class],
    ];

    public static function create(string $opcode, array $args): array
    {
        if (!array_key_exists($opcode, self::$map) || !isset(self::$map[$opcode])) {
            throw new \Exception("Unsupported opcode: $opcode");
        }

        $expectedArgTypes = self::$map[$opcode];
        $result = [];
        foreach ($expectedArgTypes as $i => $argType) {
            if (!class_exists($argType)) {
                throw new \InvalidArgumentException("Class $argType does not exist for opcode $opcode.");
            }
            if (!array_key_exists($i, $args)) {
                throw new \InvalidArgumentException("Missing argument for $argType in opcode $opcode.");
            }
            $result[] = new $argType($args[$i]);
        }

        return $result;
    }
}
