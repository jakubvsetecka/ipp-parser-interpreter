<?php

namespace IPP\Student;

abstract class Argument
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getAttributes()
    {
        return get_object_vars($this);
    }
}
