<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student;

use Exception;
use IPP\Core\AbstractInterpreter;

/**
 * The main class of the interpreter.
 */
class Interpreter extends AbstractInterpreter
{
    private ServiceLocator $service_locator;
    private FrameModel $frame_model;
    private DataStack $data_stack;
    private Scheduler $scheduler;

    public function execute(): int
    {
        try {
            $this->service_locator = new ServiceLocator();
            $this->frame_model = new FrameModel();
            $this->data_stack = new DataStack();
            $this->scheduler = new Scheduler();

            $this->service_locator->register('frame_model', $this->frame_model);
            $this->service_locator->register('data_stack', $this->data_stack);
            $this->service_locator->register('scheduler', $this->scheduler);
            $this->service_locator->register('stdout', $this->stdout);
            $this->service_locator->register('stderr', $this->stderr);
            $this->service_locator->register('stdin', $this->input);

            $dom = $this->source->getDOMDocument();
            $xml_parser = new XMLParser($dom, $this->service_locator);
            $instructions = $xml_parser->run();

            $this->scheduler->setInstructions($instructions);

            $exit_code = $this->scheduler->run();

            return $exit_code;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
