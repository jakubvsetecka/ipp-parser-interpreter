<?php

namespace IPP\Student;

use DOMDocument;
use DOMElement;

class XMLParser
{
    private DOMDocument $dom;
    private $inst_factory;

    public function __construct(DOMDocument $dom)
    {
        $this->dom = $dom;
        $this->inst_factory = new InstructionFactory();
    }

    public function run(): array
    {
        // Get all 'instruction' elements
        $instructions = $this->dom->getElementsByTagName('instruction');

        $parsedInstructions = [];

        foreach ($instructions as $instruction) {
            // Initialize an associative array to hold the instruction details
            $detail = [];

            // Directly access child nodes by tag name
            $detail['order'] = $instruction->getAttribute('order');
            $detail['opcode'] = $instruction->getAttribute('opcode');

            $arguments = $instruction->childNodes;
            foreach ($arguments as $argument) {
                if ($argument instanceof DOMElement) {
                    $detail[$argument->tagName] = $argument->nodeValue;
                }
            }

            $parsedInstructions[] = $detail;
        }

        return $parsedInstructions;
    }
}
