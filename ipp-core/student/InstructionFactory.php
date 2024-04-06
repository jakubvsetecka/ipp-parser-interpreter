<?php

namespace IPP\Student;

use IPP\Core\Exception\ParameterException;
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
use IPP\Student\Instruction\MemoryFrame\CREATEFRAMEInstruction;
use IPP\Student\Instruction\MemoryFrame\PUSHFRAMEInstruction;
use IPP\Student\Instruction\MemoryFrame\POPFRAMEInstruction;
use IPP\Student\Instruction\MemoryFrame\DEFVARInstruction;
use IPP\Student\Instruction\MemoryFrame\CALLInstruction;
use IPP\Student\Instruction\MemoryFrame\RETURNInstruction;
use IPP\Student\Instruction\DataFrame\PUSHSInstruction;
use IPP\Student\Instruction\DataFrame\POPSInstruction;

/**
 * Factory for creating instructions.
 */
class InstructionFactory
{
    private static $map = [
        'ADD' => ADDInstruction::class,
        'SUB' => SUBInstruction::class,
        'MUL' => MULInstruction::class,
        'IDIV' => IDIVInstruction::class,
        'LT' => LTInstruction::class,
        'GT' => GTInstruction::class,
        'EQ' => EQInstruction::class,
        'AND' => ANDInstruction::class,
        'OR' => ORInstruction::class,
        'NOT' => NOTInstruction::class,
        'INT2CHAR' => INT2CHARInstruction::class,
        'STR2INT' => STR2INTInstruction::class,
        'READ' => READInstruction::class,
        'WRITE' => WRITEInstruction::class,
        'CONCAT' => CONCATInstruction::class,
        'STRLEN' => STRLENInstruction::class,
        'GETCHAR' => GETCHARInstruction::class,
        'SETCHAR' => SETCHARInstruction::class,
        'TYPE' => TYPEInstruction::class,
        'LABEL' => LABELInstruction::class,
        'JUMP' => JUMPInstruction::class,
        'JUMPIFEQ' => JUMPIFEQInstruction::class,
        'JUMPIFNEQ' => JUMPIFNEQInstruction::class,
        'DPRINT' => DPRINTInstruction::class,
        'BREAK' => BREAKInstruction::class,
        'CREATEFRAME' => CREATEFRAMEInstruction::class,
        'PUSHFRAME' => PUSHFRAMEInstruction::class,
        'POPFRAME' => POPFRAMEInstruction::class,
        'DEFVAR' => DEFVARInstruction::class,
        'CALL' => CALLInstruction::class,
        'RETURN' => RETURNInstruction::class,
        'PUSHS' => PUSHSInstruction::class,
        'POPS' => POPSInstruction::class,
    ];

    /**
     * Creates an instruction based on the opcode.
     *
     * @param int $order
     * @param string $opcode
     * @param array $arguments
     * @return Instruction Returns an instance of Instruction or its subclass based on the opcode.
     */
    public static function create(int $order, string $opcode, array $arguments): Instruction
    {
        if (!array_key_exists($opcode, self::$map)) {
            throw new ParameterException("Unsupported opcode: $opcode");
        }

        $className = self::$map[$opcode];

        $instruction = new $className($order, ...$arguments);
        assert($instruction instanceof Instruction); // phpain

        return $instruction;
    }
}
