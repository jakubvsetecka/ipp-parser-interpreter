<?php

namespace IPP\Student;


abstract class instruction
{
    private string $order;
    private array $arguments;

    abstract public function execute(): void;

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
