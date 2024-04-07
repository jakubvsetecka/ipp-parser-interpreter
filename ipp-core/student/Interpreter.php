<?php

namespace IPP\Student;

use IPP\Core\AbstractInterpreter;
use IPP\Core\Exception\NotImplementedException;

class Interpreter extends AbstractInterpreter
{
    public function execute(): int
    {
        // TODO: Start your code here
        $service_locator = new ServiceLocator();
        $frame_model = new FrameModel();
        $data_stack = new DataStack();
        $scheduler = new Scheduler();

        $service_locator->register('frame_model', $frame_model);
        $service_locator->register('data_stack', $data_stack);
        $service_locator->register('scheduler', $scheduler);

        $dom = $this->source->getDOMDocument();
        $xml_parser = new XMLParser($dom, $service_locator);
        $instructions = $xml_parser->run();

        $scheduler->setInstructions($instructions);

        while ($instruction = $scheduler->getNextInstruction()) {
            $instruction->execute();
        }

        return 0;
    }
}
