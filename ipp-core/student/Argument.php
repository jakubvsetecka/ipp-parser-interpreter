<?php

namespace IPP\Student;

abstract class Argument
{
    protected $value;
    protected $regex_pattern = null;

    public function __construct($value, $regex_pattern = null)
    {
        if ($this->validate($value)) {
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

class Variable extends Argument
{
    private $frame;

    public function __construct($value)
    {
        $regex_pattern = '/^(LF|TF|GF)@([a-zA-Z_\-$&%*!?][a-zA-Z0-9_\-$&%*!?]*)$/';
        parent::__construct($value, $regex_pattern);
        $this->frame = substr($value, 0, 2);
    }

    public function getFrame()
    {
        return $this->frame;
    }

    // Inherits getValue() from Argument
}

class Constant extends Argument
{
    public function __construct($value)
    {
        $regex_pattern = '/^(int|string|bool)@(.+)$/';
        parent::__construct($value, $regex_pattern);
    }
}

class Label extends Argument
{
    // Inherits constructor and getValue() from Argument
}

class Type extends Argument
{
    public function __construct($value)
    {
        $regex_pattern = '/^(int|string|bool)$/';
        parent::__construct($value, $regex_pattern);
    }
}
