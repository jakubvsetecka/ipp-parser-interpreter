<?php

namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;


class VariableException extends IPPException
{
    public function __construct(string $message = "Variable access error", ?Throwable $previous = null)
    {
        parent::__construct($message, ReturnCode::VARIABLE_ACCESS_ERROR, $previous, false);
    }
}
