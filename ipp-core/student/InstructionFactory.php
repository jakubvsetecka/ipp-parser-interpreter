<?php

namespace IPP\Student;

use IPP\Student\Instruction\Arithmetics\ADDInstruction;
use IPP\Student\Instruction\Arithmetics\SUBInstruction;
use IPP\Student\Instruction\Arithmetics\MULInstruction;
use IPP\Student\Instruction\Arithmetics\IDIVInstruction;
use IPP\Student\Instruction\Arithmetics\LTInstruction;
use IPP\Student\Instruction\Arithmetics\GTInstruction;
use IPP\Student\Instruction\Arithmetics\EQInstruction;
use IPP\Student\Instruction\Arithmetics\ANDInstruction;
use IPP\Student\Instruction\Arithmetics\ORInstruction;
use IPP\Student\Instruction\Arithmetics\NOTInstruction;
use IPP\Student\Instruction\Arithmetics\INT2CHARInstruction;
use IPP\Student\Instruction\Arithmetics\STR2INTInstruction;
use IPP\Student\Instruction\IO\READInstruction;
use IPP\Student\Instruction\IO\WRITEInstruction;
use IPP\Student\Instruction\Strings\CONCATInstruction;
use IPP\Student\Instruction\Strings\STRLENInstruction;
use IPP\Student\Instruction\Strings\GETCHARInstruction;
use IPP\Student\Instruction\Strings\SETCHARInstruction;
use IPP\Student\Instruction\Types\TYPEInstruction;
use IPP\Student\Instruction\Control\LABELInstruction;
use IPP\Student\Instruction\Control\JUMPInstruction;
use IPP\Student\Instruction\Control\JUMPIFEQInstruction;
use IPP\Student\Instruction\Control\JUMPIFNEQInstruction;
use IPP\Student\Instruction\Debug\DPRINTInstruction;
use IPP\Student\Instruction\Debug\BREAKInstruction;

class InstructionFactory
{
    public static function create(int $order, string $opcode, array $arguments): Instruction
    {
        switch ($opcode) {
            case 'ADD':
                return new ADDInstruction($order, $arguments);
            case 'SUB':
                return new SUBInstruction($order, $arguments);
            case 'MUL':
                return new MULInstruction($order, $arguments);
            case 'IDIV':
                return new IDIVInstruction($order, $arguments);
            case 'LT':
                return new LTInstruction($order, $arguments);
            case 'GT':
                return new GTInstruction($order, $arguments);
            case 'EQ':
                return new EQInstruction($order, $arguments);
            case 'AND':
                return new ANDInstruction($order, $arguments);
            case 'OR':
                return new ORInstruction($order, $arguments);
            case 'NOT':
                return new NOTInstruction($order, $arguments);
            case 'INT2CHAR':
                return new INT2CHARInstruction($order, $arguments);
            case 'STR2INT':
                return new STR2INTInstruction($order, $arguments);
            case 'READ':
                return new READInstruction($order, $arguments);
            case 'WRITE':
                return new WRITEInstruction($order, $arguments);
            case 'CONCAT':
                return new CONCATInstruction($order, $arguments);
            case 'STRLEN':
                return new STRLENInstruction($order, $arguments);
            case 'GETCHAR':
                return new GETCHARInstruction($order, $arguments);
            case 'SETCHAR':
                return new SETCHARInstruction($order, $arguments);
            case 'TYPE':
                return new TYPEInstruction($order, $arguments);
            case 'LABEL':
                return new LABELInstruction($order, $arguments);
            case 'JUMP':
                return new JUMPInstruction($order, $arguments);
            case 'JUMPIFEQ':
                return new JUMPIFEQInstruction($order, $arguments);
            case 'JUMPIFNEQ':
                return new JUMPIFNEQInstruction($order, $arguments);
            case 'DPRINT':
                return new DPRINTInstruction($order, $arguments);
            case 'BREAK':
                return new BREAKInstruction($order, $arguments);
            default:
                throw new \Exception("Unknown opcode: $opcode");
        }
    }
}
