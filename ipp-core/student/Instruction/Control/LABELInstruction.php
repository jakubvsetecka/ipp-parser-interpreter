<?php

namespace IPP\Student\Instruction\Control;

use IPP\Student\Instruction;
use IPP\Student\Argument\LabelArgument;
use IPP\Student\Scheduler;
use IPP\Student\Exception\SemanticException;

class LABELInstruction extends Instruction
{
    private LabelArgument $label;
    private Scheduler $scheduler;

    public function __construct(int $order, LabelArgument $label, Scheduler $scheduler)
    {
        $this->order = $order;
        $this->label = $label;
        $this->scheduler = $scheduler;
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
        $callStack = $this->scheduler->getCallStack();

        if ($callStack->containsLabel($this->label->getValue())) {
            throw new SemanticException('Duplicate label');
        } else {
            $callStack->addLabel($this->label->getValue(), $this->order);
        }
    }
}
