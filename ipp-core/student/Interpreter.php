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
        $xml_parser = new XMLParser($dom);
        $instructions = $xml_parser->run();

        foreach ($instructions as $instruction) {
            $instruction->print();
        }

        return 0;
    }
}
