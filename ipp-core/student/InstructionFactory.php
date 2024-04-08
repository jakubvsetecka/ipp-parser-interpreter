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
use IPP\Student\Instruction\MemoryFrame\MOVEInstruction;
use IPP\Student\Instruction\Control\EXITInstruction;

/**
 * Factory for creating instructions.
 */
class InstructionFactory
{
    private ServiceLocator $serviceLocator;
    private static $map = [
        'ADD' => ['class' => ADDInstruction::class, 'services' => ['frame_model']],
        'SUB' => ['class' => SUBInstruction::class, 'services' => ['frame_model']],
        'MUL' => ['class' => MULInstruction::class, 'services' => ['frame_model']],
        'IDIV' => ['class' => IDIVInstruction::class, 'services' => ['frame_model']],
        'LT' => ['class' => LTInstruction::class, 'services' => ['frame_model']],
        'GT' => ['class' => GTInstruction::class, 'services' => ['frame_model']],
        'EQ' => ['class' => EQInstruction::class, 'services' => ['frame_model']],
        'AND' => ['class' => ANDInstruction::class, 'services' => ['frame_model']],
        'OR' => ['class' => ORInstruction::class, 'services' => ['frame_model']],
        'NOT' => ['class' => NOTInstruction::class, 'services' => ['frame_model']],
        'INT2CHAR' => ['class' => INT2CHARInstruction::class, 'services' => ['frame_model']],
        'STR2INT' => ['class' => STR2INTInstruction::class, 'services' => ['frame_model']],
        'READ' => ['class' => READInstruction::class, 'services' => ['frame_model', 'stdin']],
        'WRITE' => ['class' => WRITEInstruction::class, 'services' => ['frame_model', 'stdout']],
        'CONCAT' => ['class' => CONCATInstruction::class, 'services' => ['frame_model']],
        'STRLEN' => ['class' => STRLENInstruction::class, 'services' => ['frame_model']],
        'GETCHAR' => ['class' => GETCHARInstruction::class, 'services' => ['frame_model']],
        'SETCHAR' => ['class' => SETCHARInstruction::class, 'services' => ['frame_model']],
        'TYPE' => ['class' => TYPEInstruction::class, 'services' => ['frame_model']],
        'LABEL' => ['class' => LABELInstruction::class, 'services' => []],
        'JUMP' => ['class' => JUMPInstruction::class, 'services' => ['scheduler']],
        'JUMPIFEQ' => ['class' => JUMPIFEQInstruction::class, 'services' => ['scheduler', 'frame_model']],
        'JUMPIFNEQ' => ['class' => JUMPIFNEQInstruction::class, 'services' => ['scheduler', 'frame_model']],
        'DPRINT' => ['class' => DPRINTInstruction::class, 'services' => ['frame_model', 'stderr']],
        'BREAK' => ['class' => BREAKInstruction::class, 'services' => ['scheduler', 'stderr', 'frame_model']],
        'MOVE' => ['class' => MOVEInstruction::class, 'services' => ['frame_model']],
        'CREATEFRAME' => ['class' => CREATEFRAMEInstruction::class, 'services' => ['frame_model']],
        'PUSHFRAME' => ['class' => PUSHFRAMEInstruction::class, 'services' => ['frame_model']],
        'POPFRAME' => ['class' => POPFRAMEInstruction::class, 'services' => ['frame_model']],
        'DEFVAR' => ['class' => DEFVARInstruction::class, 'services' => ['frame_model']],
        'CALL' => ['class' => CALLInstruction::class, 'services' => ['scheduler']],
        'RETURN' => ['class' => RETURNInstruction::class, 'services' => ['scheduler']],
        'PUSHS' => ['class' => PUSHSInstruction::class, 'services' => ['data_stack', 'frame_model']],
        'POPS' => ['class' => POPSInstruction::class, 'services' => ['data_stack', 'frame_model']],
        'EXIT' => ['class' => EXITInstruction::class, 'services' => ['scheduler']],
    ];

    public function __construct(ServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Creates an instruction based on the opcode.
     *
     * @param int $order
     * @param string $opcode
     * @param array $arguments
     * @return Instruction Returns an instance of Instruction or its subclass based on the opcode.
     */
    public function create(int $order, string $opcode, array $arguments): Instruction
    {
        if (!array_key_exists($opcode, self::$map)) {
            throw new ParameterException("Unsupported opcode: $opcode");
        }

        $config = self::$map[$opcode];
        $className = $config['class'];

        $services = [];
        if (isset($config['services'])) {
            // Fetch each service and add it to the services array
            foreach ($config['services'] as $serviceType) {
                $services[] = $this->serviceLocator->get($serviceType);
            }
        }

        // Use the ... operator to pass $services as individual arguments
        $instruction = new $className($order, ...$arguments, ...$services);

        assert($instruction instanceof Instruction);

        return $instruction;
    }
}
