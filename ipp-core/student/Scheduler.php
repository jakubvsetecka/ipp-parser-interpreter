<?php

namespace IPP\Student;

use IPP\Core\Interface\OutputWriter;
use IPP\Student\Exception\MissingValueException;
use IPP\Student\Exception\SemanticException;

class Scheduler
{
    private array $instructions = [];
    private ProgramCounter $program_counter;
    private CallStack $call_stack;
    private bool $return = false;
    private int $exit_code = 0;

    public function __construct()
    {
        $this->program_counter = new ProgramCounter();
        $this->call_stack = new CallStack();
    }

    public function run(): int // Return type is int
    {
        while ($this->return === false && ($instruction = $this->getNextInstruction()) !== null) {
            $instruction->execute();
        }

        return $this->exit_code; // Or return appropriate exit code
    }

    public function getCallStack(): CallStack
    {
        return $this->call_stack;
    }

    public function setInstructions(array $instructions): void
    {
        $this->instructions = $instructions;
    }

    public function getInstructions(): array
    {
        return $this->instructions;
    }

    public function getNextInstruction(): ?Instruction // Allow null to be returned
    {
        if ($this->program_counter->getCounter() >= count($this->instructions)) {
            return null; // Or handle end-of-instructions scenario as appropriate
        }

        $instruction = $this->instructions[$this->program_counter->getCounter()];
        $this->program_counter->increment();
        return $instruction;
    }

    public function call(string $label): void
    {
        $this->call_stack[] = $this->program_counter->getCounter();
        $this->jump($label);
    }

    public function ret(): void
    {
        if ($this->call_stack->isEmpty()) {
            throw new MissingValueException("Call stack is empty");
        }
        $this->program_counter->setCounter($this->call_stack->pop());
    }

    public function jump(string $label): void
    {
        foreach ($this->instructions as $index => $instruction) {
            if ($instruction->getLabel() === $label) {
                $this->program_counter->setCounter($index);
                return;
            }
        }

        throw new SemanticException("Label $label not found");
    }

    public function exit(int $value): void
    {
        $this->return = true;
        $this->exit_code = $value;
    }
}
