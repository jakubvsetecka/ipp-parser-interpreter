<?php

namespace IPP\Student\Argument\RegexPattern;

enum RegexPattern: string
{
    case Variable = '/^(LF|TF|GF)@([a-zA-Z_\-$&%*!?][a-zA-Z0-9_\-$&%*!?]*)$/';
    case Symbol = '/^(string@([a-zA-Z]|_|-|\$|&|%|\*|!|\?)([a-zA-Z0-9]|_|-|\$|&|%|\*|!|\?)*$)|' .
        '(^int@[-+]?[0-9]+$)|' .
        '(^bool@(true|false)$)|' .
        '(^nil@nil$)|' .
        '(^(LF|TF|GF)@([a-zA-Z_\-$&%*!?][a-zA-Z0-9_\-$&%*!?]*)$)/';
    case Label = '/^([a-zA-Z_\-$&%*!?][a-zA-Z0-9_\-$&%*!?])*$/';
    case Type = '/^(nil|int|string|bool)$/';

    case BeforeAt = '/^[^@]+/'; // Matches everything before '@'
    case AfterAt = '/[^@]+$/'; // Matches everything after '@

    public function match(string $subject): bool
    {
        return preg_match($this->value, $subject) === 1;
    }

    public function getValue(string $subject): string
    {
        preg_match($this->value, $subject, $matches);

        // Check if a full match was found
        if (empty($matches)) {
            throw new \Exception("Invalid argument value: $subject");
        }

        // Return the full match
        return $matches[0];
    }
}
