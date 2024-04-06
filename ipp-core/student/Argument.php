<?php

namespace IPP\Student;

abstract class Argument
{
    protected $value;
    protected $regex_pattern = null;

    public function __construct($value, $regex_pattern = null)
    {
        if (!$this->validate($value)) {
            throw new \Exception("Invalid argument value: $value");
        }
        $this->value = $value;
        $this->regex_pattern = $regex_pattern;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function validate(): bool
    {
        if ($this->regex_pattern === null) {
            return true;
        }

        return preg_match($this->regex_pattern, $this->value);
    }
}
