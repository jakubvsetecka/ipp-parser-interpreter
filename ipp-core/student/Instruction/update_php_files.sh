#!/bin/bash

# Find all PHP files in the directory structure
find . -type f -name "*.php" | while read file; do
    # Extract class name from the file path
    classname=$(basename "$file" .php)
    foldername=$(dirname "$file" | cut -d/ -f2- | tr / \\)
    echo "Creating class $classname in folder $foldername"

    # Write the PHP code to the file, replacing <nameoffile> with the actual class name
    cat > "$file" <<EOF
<?php

namespace IPP\Student\Instruction\\$(dirname "$file" | cut -d/ -f2- | tr / \\);

use IPP\Student\Instruction;

class $classname extends Instruction
{
    public function execute(): void
    {
    }
}
EOF
done
