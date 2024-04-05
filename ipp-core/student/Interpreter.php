<?php

namespace IPP\Student;

use IPP\Core\AbstractInterpreter;
use IPP\Core\Exception\NotImplementedException;

class Interpreter extends AbstractInterpreter
{
    public function execute(): int
    {
        // TODO: Start your code here
        // Check \IPP\Core\AbstractInterpreter for predefined I/O objects:
        //$val = $this->input->readString();
        //$this->stderr->writeString("stderr");
        //$this->stdout->writeString("stdout");
        $dom = $this->source->getDOMDocument();
        $instructionGenerator = new InstructionGenerator($dom);

        foreach ($instructionGenerator->run() as $instruction) {
            // Process the instruction
            fwrite(STDOUT, json_encode($instruction, JSON_PRETTY_PRINT) . PHP_EOL);
        }
        return 0;
    }
}
