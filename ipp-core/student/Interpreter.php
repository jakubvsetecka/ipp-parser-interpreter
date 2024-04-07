<?php

namespace IPP\Student;

use Exception;
use IPP\Core\AbstractInterpreter;
use IPP\Core\Exception\NotImplementedException;

class Interpreter extends AbstractInterpreter
{
    public function execute(): int
    {
        try {

            // TODO: Start your code here
            $service_locator = new ServiceLocator();
            $frame_model = new FrameModel();
            $data_stack = new DataStack();
            $scheduler = new Scheduler();

            $service_locator->register('frame_model', $frame_model);
            $service_locator->register('data_stack', $data_stack);
            $service_locator->register('scheduler', $scheduler);
            $service_locator->register('stdout', $this->stdout);

            echo "Interpreter is running\n";

            $dom = $this->source->getDOMDocument();
            $xml_parser = new XMLParser($dom, $service_locator);
            $instructions = $xml_parser->run();

            echo "Instructions parsed\n";

            $scheduler->setInstructions($instructions);

            while ($instruction = $scheduler->getNextInstruction()) {
                $instruction->print();
                $instruction->execute();
            }

            return 0;
        } catch (Exception $e) {
            echo "Exception:";
            echo $e->getMessage();
            return 99;
        }
    }
}
