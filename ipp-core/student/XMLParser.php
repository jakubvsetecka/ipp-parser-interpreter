<?php

namespace IPP\Student;

use DOMDocument;
use DOMElement;

class XMLParser
{
    private DOMDocument $dom;
    private $inst_factory;
    private $arg_factory;

    public function __construct(DOMDocument $dom, ServiceLocator $service_locator)
    {
        $this->dom = $dom;
        $this->inst_factory = new InstructionFactory($service_locator);
        $this->arg_factory = new ArgumentFactory();
    }

    public function run(): array
    {
        $instructions = $this->getInstructions();
        $instructions = $this->sortInstructions($instructions);

        return $instructions;
    }

    private function getInstructions(): array
    {
        // Get all 'instruction' elements
        $instructions = $this->dom->getElementsByTagName('instruction');

        $parsedInstructions = [];

        foreach ($instructions as $instruction) {
            // Directly access child nodes by tag name
            $order = $instruction->getAttribute('order');
            $opcode = $instruction->getAttribute('opcode');

            // Initialize an array to hold the argument strings
            $argumentStrings = [];
            foreach ($instruction->childNodes as $childNode) {
                // Check if the node is a DOMElement and has textContent
                if ($childNode instanceof \DOMElement) {
                    $argumentStrings[] = $childNode->textContent;
                }
            }

            // Pass the array of strings to your factory method
            $arguments = $this->arg_factory->create($opcode, $argumentStrings);

            $parsedInstructions[] = $this->inst_factory->create($order, $opcode, $arguments);
        }

        return $parsedInstructions;
    }

    private function sortInstructions(array $instructions): array
    {
        usort($instructions, function ($a, $b) {
            if ($a->getOrder() === $b->getOrder()) {
                throw new \Exception("Duplicate order value: {$a->getOrder()}");
            }
            return $a->getOrder() <=> $b->getOrder();
        });

        return $instructions;
    }
}
