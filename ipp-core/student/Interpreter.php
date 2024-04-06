<?php

namespace IPP\Student;

use IPP\Core\AbstractInterpreter;
use IPP\Core\Exception\NotImplementedException;

class Interpreter extends AbstractInterpreter
{
    public function execute(): int
    {
        // TODO: Start your code here

        $dom = $this->source->getDOMDocument();
        $xml_parser = new XMLParser($dom);
        $instructions = $xml_parser->run();

        global $SCHEDULER;
        $SCHEDULER = new Scheduler($instructions);

        $SCHEDULER->print();

        while ($instruction = $SCHEDULER->getNextInstruction()) {
            $instruction->execute();
        }

        return 0;
    }
}
