<?php

/**
 * IPP - PHP Project Core
 * @author Jakub Všetečka
 */

namespace IPP\Student;

use DOMDocument;
use IPP\Student\Exception\SemanticException;
use IPP\Student\Exception\XMLStructureException;
use IPP\Student\Instruction\Control\LABELInstruction;

/**
 * XML parser.
 */
class XMLParser
{
    private DOMDocument $dom;
    private InstructionFactory $inst_factory;
    private ArgumentFactory $arg_factory;
    /**
     * @var array<int>
     */
    private array $orders = [];
    /**
     * @var array<string>
     */
    private array $labels = [];

    public function __construct(DOMDocument $dom, ServiceLocator $service_locator)
    {
        $this->dom = $dom;
        $this->inst_factory = new InstructionFactory($service_locator);
        $this->arg_factory = new ArgumentFactory();
    }

    /**
     * @return array<Instruction>
     */
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

        if ($root === null) {
            throw new XMLStructureException('Invalid XML structure');
        }

        if ($root->getAttribute('language') !== 'IPPcode24') {
            throw new XMLStructureException('Invalid language');
        }

        foreach ($root->childNodes as $childNode) {
            // Check if the node is an element node
            if ($childNode->nodeType === XML_ELEMENT_NODE) {
                // Check if the node is an instruction
                if ($childNode instanceof \DOMElement) {
                    if ($childNode->tagName !== 'instruction') {
                        throw new XMLStructureException('Invalid XML structure: Only <instruction> elements are allowed directly under <program>');
                    }
                }
            }
        }
    }

    /**
     * @return array<Instruction>
     */
    private function getInstructions(): array
    {
        // Get all 'instruction' elements
        $instructions = $this->dom->getElementsByTagName('instruction');

        $parsedInstructions = [];

        foreach ($instructions as $instruction) {
            // Directly access child nodes by tag name
            $opcode = $instruction->getAttribute('opcode');
            $order = (int)$instruction->getAttribute('order');

            if ($order < 1) {
                throw new XMLStructureException('Order must be a positive integer');
            }

            $opcode = strtoupper($opcode);

            // Initialize an array to hold the argument strings
            $arguments = [];
            $children = $this->getChildren($instruction);

            foreach ($children as $childNode) {
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
                    throw new SemanticException('Label: ' . $label . ' is not unique');
                }
                $this->labels[] = $label;
            }

            $this->orders[] = $instruction->getOrder();

            $parsedInstructions[] = $instruction;
        }

        return $parsedInstructions;
    }

    /**
     * @param array<Instruction> $instructions
     * @return array<Instruction>
     */
    private function sortInstructions(array $instructions): array
    {
        usort($instructions, function ($a, $b) {
            return $a->getOrder() <=> $b->getOrder();
        });

        return $instructions;
    }

    /**
     * @param \DOMNode $node
     * @return array<\DOMNode>
     */
    private function getChildren(\DOMNode $node): array
    {
        $children = [];
        $openNames = ['arg1', 'arg2', 'arg3'];
        foreach ($node->childNodes as $child) {
            if ($child->nodeType === XML_ELEMENT_NODE) {
                if (in_array($child->nodeName, $openNames)) {
                    $children[] = $child;
                    $openNames = array_diff($openNames, [$child->nodeName]);
                } else {
                    throw new XMLStructureException('Invalid XML structure');
                }
            }
        }

        usort($children, function ($a, $b) {
            return $a->nodeName <=> $b->nodeName;
        });

        return $children;
    }
}
