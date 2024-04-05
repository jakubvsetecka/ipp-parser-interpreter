<?php

namespace IPP\Student;


abstract class instruction
{
    private int $order;
    private array $arguments;

    abstract public function execute(): void;

    /**
     * Instruction constructor.
     * @param int $order
     * @param array<Argument> $arguments
     */
    public function __construct(string $order, array $arguments)
    {
        $this->order = $order;
        $this->arguments = $arguments;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }
}
