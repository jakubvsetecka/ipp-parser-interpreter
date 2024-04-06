<?php

namespace IPP\Student\Instruction\Control;

use IPP\Student\Instruction;
use IPP\Student\Argument\LabelArgument;
use IPP\Student\Argument\SymbolArgument;

class JUMPIFNEQInstruction extends Instruction
{
    private LabelArgument $label;
    private SymbolArgument $source1;
    private SymbolArgument $source2;

    public function __construct(int $order, LabelArgument $label, SymbolArgument $source1, SymbolArgument $source2)
    {
        parent::__construct($order);
        $this->label = $label;
        $this->source1 = $source1;
        $this->source2 = $source2;
    }

    public function execute(): void
    {
    }
}
