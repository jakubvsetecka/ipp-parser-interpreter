<?php

namespace IPP\Student;

use DOMDocument;
use DOMElement;
use IPP\Student\Exception\XMLStructureException;
use IPP\Student\Instruction\Control\LABELInstruction;

class XMLParser
{
    private DOMDocument $dom;
    private InstructionFactory $inst_factory;
    private ArgumentFactory $arg_factory;
    private array $orders = [];
    private array $labels = [];

    public function __construct(DOMDocument $dom, ServiceLocator $service_locator)
    {
        $this->dom = $dom;
        $this->inst_factory = new InstructionFactory($service_locator);
        $this->arg_factory = new ArgumentFactory();
    }

    public function run(): array
    {
        $this->validateLanguage();
        $instructions = $this->getInstructions();
        $instructions = $this->sortInstructions($instructions);

        return $instructions;
    }

    private function validateLanguage(): void
    {
        $root = $this->dom->documentElement;

        if ($root->getAttribute('language') !== 'IPPcode24') {
            throw new XMLStructureException('Invalid language');
        }
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
                throw new XMLStructureException('Order must be unique');
            }

            if ($instruction instanceof LABELInstruction) {
                $label = $instruction->getLabel();
                if (in_array($label, $this->labels)) {
                    throw new XMLStructureException('Label: ' . $label . ' is not unique');
                }
                $this->labels[] = $label;
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
