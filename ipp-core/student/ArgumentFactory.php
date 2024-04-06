<?php

namespace IPP\Student;

use IPP\Student\Argument\LabelArgument;
use IPP\Student\Argument\SymbolArgument;
use IPP\Student\Argument\TypeArgument;
use IPP\Student\Argument\VariableArgument;

class ArgumentFactory
{
    public static function create(string $opcode, array $args): array
    {
        switch ($opcode) {
            case 'ADD':
                $var = new VariableArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                $symb2 = new SymbolArgument($args[2]);
                return [
                    'var' => $var,
                    'symb1' => $symb1,
                    'symb2' => $symb2
                ];
            case 'SUB':
                $var = new VariableArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                $symb2 = new SymbolArgument($args[2]);
                return [
                    'var' => $var,
                    'symb1' => $symb1,
                    'symb2' => $symb2
                ];
            case 'MUL':
                $var = new VariableArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                $symb2 = new SymbolArgument($args[2]);
                return [
                    'var' => $var,
                    'symb1' => $symb1,
                    'symb2' => $symb2
                ];
            case 'IDIV':
                $var = new VariableArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                $symb2 = new SymbolArgument($args[2]);
                return [
                    'var' => $var,
                    'symb1' => $symb1,
                    'symb2' => $symb2
                ];
            case 'LT':
                $var = new VariableArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                $symb2 = new SymbolArgument($args[2]);
                return [
                    'var' => $var,
                    'symb1' => $symb1,
                    'symb2' => $symb2
                ];
            case 'GT':
                $var = new VariableArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                $symb2 = new SymbolArgument($args[2]);
                return [
                    'var' => $var,
                    'symb1' => $symb1,
                    'symb2' => $symb2
                ];
            case 'EQ':
                $var = new VariableArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                $symb2 = new SymbolArgument($args[2]);
                return [
                    'var' => $var,
                    'symb1' => $symb1,
                    'symb2' => $symb2
                ];
            case 'AND':
                $var = new VariableArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                $symb2 = new SymbolArgument($args[2]);
                return [
                    'var' => $var,
                    'symb1' => $symb1,
                    'symb2' => $symb2
                ];
            case 'OR':
                $var = new VariableArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                $symb2 = new SymbolArgument($args[2]);
                return [
                    'var' => $var,
                    'symb1' => $symb1,
                    'symb2' => $symb2
                ];
            case 'NOT':
                $var = new VariableArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                return [
                    'var' => $var,
                    'symb1' => $symb1
                ];
            case 'INT2CHAR':
                $var = new VariableArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                return [
                    'var' => $var,
                    'symb1' => $symb1
                ];
            case 'STR2INT':
                $var = new VariableArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                $symb2 = new SymbolArgument($args[2]);
                return [
                    'var' => $var,
                    'symb1' => $symb1,
                    'symb2' => $symb2
                ];
            case 'READ':
                $var = new VariableArgument($args[0]);
                $type = new TypeArgument($args[1]);
                return [$var, $type];
            case 'WRITE':
                $symb = new SymbolArgument($args[0]);
                return [
                    'symb' => $symb
                ];
            case 'CONCAT':
                $var = new VariableArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                $symb2 = new SymbolArgument($args[2]);
                return [
                    'var' => $var,
                    'symb1' => $symb1,
                    'symb2' => $symb2
                ];
            case 'STRLEN':
                $var = new VariableArgument($args[0]);
                $symb = new SymbolArgument($args[1]);
                return [
                    'var' => $var,
                    'symb' => $symb
                ];
            case 'GETCHAR':
                $var = new VariableArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                $symb2 = new SymbolArgument($args[2]);
                return [
                    'var' => $var,
                    'symb1' => $symb1,
                    'symb2' => $symb2
                ];
            case 'SETCHAR':
                $var = new VariableArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                $symb2 = new SymbolArgument($args[2]);
                return [
                    'var' => $var,
                    'symb1' => $symb1,
                    'symb2' => $symb2
                ];
            case 'TYPE':
                $var = new VariableArgument($args[0]);
                $symb = new SymbolArgument($args[1]);
                return [
                    'var' => $var,
                    'symb' => $symb
                ];
            case 'LABEL':
                $label = new LabelArgument($args[0]);
                return [
                    'label' => $label
                ];
            case 'JUMP':
                $label = new LabelArgument($args[0]);
                return [
                    'label' => $label
                ];
            case 'JUMPIFEQ':
                $label = new LabelArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                $symb2 = new SymbolArgument($args[2]);
                return [
                    'label' => $label,
                    'symb1' => $symb1,
                    'symb2' => $symb2
                ];
            case 'JUMPIFNEQ':
                $label = new LabelArgument($args[0]);
                $symb1 = new SymbolArgument($args[1]);
                $symb2 = new SymbolArgument($args[2]);
                return [
                    'label' => $label,
                    'symb1' => $symb1,
                    'symb2' => $symb2
                ];
            case 'DPRINT':
                $symb = new SymbolArgument($args[0]);
                return [
                    'symb' => $symb
                ];
            case 'BREAK':
                return [];
            case 'CREATEFRAME':
                return [];
            case 'PUSHFRAME':
                return [];
            case 'POPFRAME':
                return [];
            case 'DEFVAR':
                $var = new VariableArgument($args[0]);
                return [
                    'var' => $var
                ];
            case 'CALL':
                $label = new LabelArgument($args[0]);
                return [
                    'label' => $label
                ];
            case 'RETURN':
                return [];
            case 'PUSHS':
                $symb = new SymbolArgument($args[0]);
                return [
                    'symb' => $symb
                ];
            case 'POPS':
                $var = new VariableArgument($args[0]);
                return [
                    'var' => $var
                ];
            default:
                throw new \Exception("Unknown opcode: $opcode");
        }
    }
}
