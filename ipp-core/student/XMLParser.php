<?php

namespace IPP\Student;

use DOMDocument;
use DOMElement;

class XMLParser
{
    private DOMDocument $dom;
    private InstructionFactory $inst_factory;
    private ArgumentFactory $arg_factory;
    private array $orders = [];

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
            $opcode = strtoupper($opcode);

            // Initialize an array to hold the argument strings
            $arguments = [];
            foreach ($instruction->childNodes as $childNode) {
                // Check if the node is a DOMElement and has textContent
                if ($childNode instanceof \DOMElement) {
                    $type = $childNode->getAttribute('type');
                    $value = $childNode->textContent;
                    $arguments[] = $this->arg_factory->create($type, $value);
                }
            }

            $instruction = $this->inst_factory->create($order, $opcode, $arguments);

            if (in_array($instruction->getOrder(), $this->orders)) {
                echo "Order must be unique\n";
                throw new \Exception('Order must be unique');
            }

            $this->orders[] = $instruction->getOrder();

            $parsedInstructions[] = $instruction;
        }

        return $parsedInstructions;
    }

    private function sortInstructions(array $instructions): array
    {
        usort($instructions, function ($a, $b) {
            return $a->getOrder() <=> $b->getOrder();
        });

        return $instructions;
    }
}
