<?php

namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;


class OperandTypeException extends IPPException
{
    public function __construct(string $message = "Operand type error", ?Throwable $previous = null)
    {
        parent::__construct($message, ReturnCode::OPERAND_TYPE_ERROR, $previous, false);
    }
}