<?php

namespace IPP\Student;

abstract class Argument
{
    protected string|int|bool|null $value;

    public function __construct(string|int|bool|null $value)
    {
        $this->value = $value;
    }

    public function getValue(): string|int|bool|null
    {
        return $this->value;
    }

    /**
     * @return array<string|mixed>
     */
    public function getAttributes(): array
    {
        return get_object_vars($this);
    }
}
