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
            $service_locator->register('stderr', $this->stderr);
            $service_locator->register('stdin', $this->input);

            $dom = $this->source->getDOMDocument();
            $xml_parser = new XMLParser($dom, $service_locator);
            $instructions = $xml_parser->run();

            $scheduler->setInstructions($instructions);

            $exit_code = $scheduler->run();

            return $exit_code;
        } catch (Exception $e) {
            // echo $e->getMessage();
            // echo $e->getTraceAsString();
            throw $e;
        }
    }
}
