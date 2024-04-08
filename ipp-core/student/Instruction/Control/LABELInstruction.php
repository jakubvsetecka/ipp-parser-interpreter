<?php

namespace IPP\Student\Instruction\Control;

use IPP\Student\Instruction;
use IPP\Student\Argument\LabelArgument;

class LABELInstruction extends Instruction
{
    private LabelArgument $label;

    public function __construct(int $order, LabelArgument $label)
    {
        $this->order = $order;
        $this->label = $label;
    }

    public function execute(): void
    {
        // Roses are red,
        // Violets are blue,
        // This is a LABEL,
        // And it does nothing too.

        // But it's important to remember,
        // That LABELs are not just for show,
        // They are used to mark a place,
        // Where we might want to go.

        // So when you see a LABEL,
        // Don't just skip it by,
        // It might be important,
        // And you'll want to know why.

        // So let's give a cheer,
        // For the LABELs we see,
        // They might not do much,
        // But they're important to me.
    }

    public function getLabel(): string
    {
        return (string)$this->label->getValue();
    }
}
